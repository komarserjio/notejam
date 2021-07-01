import unittest

from webtest import TestApp
from pyramid import testing

from sqlalchemy import create_engine

from models import DBSession, Base, User, Pad, Note


class BaseTestCase(unittest.TestCase):
    def setUp(self):
        self.config = testing.setUp()

        # @TODO change this
        from . import main
        settings = {'sqlalchemy.url': 'sqlite://', 'session.secret': 'secret'}
        app = main({}, **settings)
        self.testapp = TestApp(app)

        engine = create_engine('sqlite://')
        DBSession.configure(bind=engine)
        Base.metadata.create_all(engine)

    def tearDown(self):
        DBSession.remove()
        testing.tearDown()

    def signin(self, email, password):
        '''
        To have signed in user for next WebTest requests
        Usage:
            self.signin(email='user@example.com', password='password')
            .... next requests

        Definitely should be better way to sign in user for testing purposes.
        '''
        self.testapp.post(
            '/signup/',
            {'email': email,
             'password': password,
             'confirm_password': password}
        )
        self.testapp.post('/signin/', {'email': email, 'password': password})

    def get_form_error_fields(self, response):
        ''' Extract error field names from html '''
        errors = []
        inputs = response.html.form.find_all(["input", "select", "textarea"])
        for i in inputs:
            if i.attrs.get("type") != "submit":
                if i.next_sibling.next_sibling.name == "ul":
                    errors.append(i['id'])
        return errors


class SignupTestCase(BaseTestCase):
    def _get_user_data(self, **kwargs):
        user_data = {
            'email': 'email@example.com',
            'password': 'secure_password',
            'confirm_password': 'secure_password'
        }
        user_data.update(**kwargs)
        return user_data

    def test_signup_success(self):
        # TODO how to get url from the route config?
        self.testapp.post("/signup/", self._get_user_data(), status=302)

    def test_signup_fail_required_fields(self):
        response = self.testapp.post("/signup/", {})
        self.assertEquals(
            set(self._get_user_data().keys()),
            set(self.get_form_error_fields(response))
        )

    def test_signup_fail_email_exists(self):
        data = self._get_user_data()
        create_object(User, email=data['email'], password=data['password'])

        response = self.testapp.post("/signup/", self._get_user_data())
        self.assertEquals(
            set(['email']), set(self.get_form_error_fields(response))
        )

    def test_signup_fail_invalid_email(self):
        data = self._get_user_data(email='invalid emails')

        response = self.testapp.post("/signup/", data)
        self.assertEquals(
            set(['email']), set(self.get_form_error_fields(response))
        )

    def test_signup_fail_passwords_dont_match(self):
        invalid_data = self._get_user_data(password='another pass')
        response = self.testapp.post("/signup/", invalid_data)

        self.assertEquals(
            set(['confirm_password']),
            set(self.get_form_error_fields(response))
        )


class SigninTestCase(BaseTestCase):
    def _get_user_data(self, **kwargs):
        user_data = {
            'email': 'email@example.com',
            'password': 'secure_password'
        }
        user_data.update(**kwargs)
        return user_data

    def test_signin_success(self):
        data = self._get_user_data()
        create_object(User, **data)

        self.testapp.post("/signin/", data, status=302)

    def test_signin_fail(self):
        response = self.testapp.post(
            '/signin/', self._get_user_data())
        self.assertIn('Wrong email or password', response.body)

    def test_signin_fail_required_fields(self):
        response = self.testapp.post('/signin/', {})
        self.assertEquals(
            set(self._get_user_data().keys()),
            set(self.get_form_error_fields(response))
        )

    def test_signup_fail_invalid_email(self):
        data = self._get_user_data(email='invalid email')

        response = self.testapp.post('/signin/', data)
        self.assertEquals(
            ['email'], self.get_form_error_fields(response))


class PadTestCase(BaseTestCase):

    def test_create_success(self):
        user_data = {'email': 'email@example.com', 'password': 'password'}
        create_object(User, **user_data)
        self.signin(**user_data)

        self.testapp.post('/pads/create/', {'name': 'pad'}, status=302)
        self.assertEquals(1, DBSession.query(Pad).count())

    def test_create_fail_required_name(self):
        user_data = {'email': 'email@example.com', 'password': 'password'}
        create_object(User, **user_data)
        self.signin(**user_data)

        response = self.testapp.post('/pads/create/', {})
        self.assertEquals(
            ['name'], self.get_form_error_fields(response))

    def test_create_fail_anonymous_user(self):
        response = self.testapp.post('/pads/create/', {'name': 'pad'})
        self.assertIn('sign-in', response.html.find('form')['class'])
        self.assertEquals(0, DBSession.query(Pad).count())

    def test_edit_success(self):
        user_data = {'email': 'email@example.com', 'password': 'password'}
        user = create_object(User, **user_data)
        self.signin(**user_data)

        pad = create_object(Pad, name='pad', user=user)
        new_name = 'new pad name'
        self.testapp.post(
            '/pads/{}/edit/'.format(pad.id), {'name': new_name}, status=302)
        self.assertEquals(new_name, DBSession.query(Pad).get(pad.id).name)

    def test_edit_fail_required_name(self):
        user_data = {'email': 'email@example.com', 'password': 'password'}
        create_object(User, **user_data)
        self.signin(**user_data)

        response = self.testapp.post('/pads/create/', {})
        self.assertEquals(
            ['name'], self.get_form_error_fields(response))

    def test_edit_fail_anothers_user(self):
        user_data = {'email': 'email@example.com', 'password': 'password'}
        user = create_object(User, **user_data)
        pad = create_object(Pad, name='pad', user=user)
        another_user_data = {
            'email': 'another@example.com', 'password': 'password'
        }
        create_object(User, **another_user_data)
        self.signin(email='another@example.com', password='password')
        response = self.testapp.post(
            '/pads/{}/edit/'.format(pad.id),
            {'name': 'new name'}, expect_errors=True)
        self.assertEquals(response.status_code, 404)

    def test_delete_success(self):
        user_data = {'email': 'email@example.com', 'password': 'password'}
        user = create_object(User, **user_data)
        pad = create_object(Pad, name='pad', user=user)
        self.signin(**user_data)
        self.testapp.post(
            '/pads/{}/delete/'.format(pad.id),
            {'name': 'new name'}, status=302)
        self.assertEquals(0, DBSession.query(Pad).count())

    def test_delete_fail_anothers_user(self):
        user_data = {'email': 'email@example.com', 'password': 'password'}
        user = create_object(User, **user_data)
        pad = create_object(Pad, name='pad', user=user)
        another_user_data = {
            'email': 'another@example.com', 'password': 'password'
        }
        create_object(User, **another_user_data)
        self.signin(email='another@example.com', password='password')
        response = self.testapp.post(
            '/pads/{}/delete/'.format(pad.id), {}, expect_errors=True)
        self.assertEquals(response.status_code, 404)


class NoteTestCase(BaseTestCase):
    def _get_note_data(self, **kwargs):
        note_data = {
            'name': 'note', 'pad_id': 0, 'text': 'text'
        }
        note_data.update(**kwargs)
        return note_data

    def test_create_success(self):
        user_data = {'email': 'email@example.com', 'password': 'password'}
        create_object(User, **user_data)
        self.signin(**user_data)
        self.testapp.post('/notes/create/', self._get_note_data(), status=302)
        self.assertEquals(1, DBSession.query(Note).count())

    def test_create_fail_required_fields(self):
        user_data = {'email': 'email@example.com', 'password': 'password'}
        create_object(User, **user_data)
        self.signin(**user_data)
        response = self.testapp.post('/notes/create/', {})
        self.assertEquals(
            set(self._get_note_data().keys()),
            set(self.get_form_error_fields(response))
        )

    def test_create_fail_anothers_user_pad(self):
        user_data = {'email': 'email@example.com', 'password': 'password'}
        create_object(User, **user_data)
        another_user = create_object(
            User, email='another@example.com', password='password')
        another_user_pad = create_object(Pad, name='pad', user=another_user)
        self.signin(**user_data)
        response = self.testapp.post(
            '/notes/create/', self._get_note_data(pad_id=another_user_pad.id))
        self.assertEquals(['pad_id'], self.get_form_error_fields(response))

    def test_create_fail_anonymous_user(self):
        response = self.testapp.post('/notes/create/', self._get_note_data())
        self.assertIn('sign-in', response.html.find('form')['class'])
        self.assertEquals(0, DBSession.query(Note).count())

    def test_edit_success(self):
        user_data = {'email': 'email@example.com', 'password': 'password'}
        user = create_object(User, **user_data)
        self.signin(**user_data)

        note = create_object(Note, name='note', text='text', user=user)
        new_name = 'new note name'
        self.testapp.post(
            '/notes/{}/edit/'.format(note.id),
            {'name': new_name, 'pad_id': 0, 'text': 'text'}
        )
        self.assertEquals(new_name, DBSession.query(Note).get(note.id).name)

    def test_edit_fail_required_fields(self):
        user_data = {'email': 'email@example.com', 'password': 'password'}
        user = create_object(User, **user_data)
        self.signin(**user_data)

        note = create_object(Note, name='note', text='text', user=user)
        response = self.testapp.post(
            '/notes/{}/edit/'.format(note.id), {}
        )
        self.assertEquals(
            set(self._get_note_data().keys()),
            set(self.get_form_error_fields(response))
        )

    def test_edit_fail_anothers_user(self):
        user_data = {'email': 'email@example.com', 'password': 'password'}
        user = create_object(User, **user_data)
        note = create_object(Note, name='note', text='text', user=user)
        another_user_data = {
            'email': 'another@example.com', 'password': 'password'
        }
        create_object(User, **another_user_data)
        self.signin(email='another@example.com', password='password')
        response = self.testapp.post(
            '/pads/{}/edit/'.format(note.id),
            {'name': 'new name', 'text': 'text', 'pad_id': 0},
            expect_errors=True)
        self.assertEquals(response.status_code, 404)

    def test_delete_success(self):
        user_data = {'email': 'email@example.com', 'password': 'password'}
        user = create_object(User, **user_data)
        note = create_object(Note, name='note', text='text', user=user)
        self.signin(**user_data)
        self.testapp.post(
            '/notes/{}/delete/'.format(note.id),
            {'name': 'new name'}, status=302)
        self.assertEquals(0, DBSession.query(Note).count())

    def test_delete_fail_anothers_user(self):
        user_data = {'email': 'email@example.com', 'password': 'password'}
        user = create_object(User, **user_data)
        note = create_object(Note, name='note', text='text', user=user)
        another_user_data = {
            'email': 'another@example.com', 'password': 'password'
        }
        create_object(User, **another_user_data)
        self.signin(email='another@example.com', password='password')
        response = self.testapp.post(
            '/pads/{}/delete/'.format(note.id), {}, expect_errors=True)
        self.assertEquals(response.status_code, 404)


def create_object(object_class, **object_data):
    obj = object_class(**object_data)
    DBSession.add(obj)
    DBSession.flush()
    return obj
