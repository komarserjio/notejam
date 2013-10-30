import unittest

from webtest import TestApp
from pyramid import testing

from sqlalchemy import create_engine

from models import DBSession, Base, User


class BaseTestCase(unittest.TestCase):
    def setUp(self):
        self.config = testing.setUp()

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

    def signin(self, email, password='secure'):
        '''
        To have signed in user for next WebTest requests
        Usage:
            self.signin(email='user@example.com')
            .... next requests

        Don't like this approach. Sorry.
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
        errors = []
        inputs = response.html.form.find_all("input")
        for i in inputs:
            if i.next_element.next_element.name == "ul":
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
        self.testapp.post("/signup/", self._get_user_data(), status=302)

    def test_signup_fail_required_fields(self):
        response = self.testapp.post("/signup/", {})
        self.assertEquals(
            set(self._get_user_data().keys()),
            set(self.get_form_error_fields(response))
        )

    def test_signup_fail_email_exists(self):
        data = self._get_user_data()
        create_user(email=data['email'], password=data['password'])

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
        import ipdb
        ipdb.set_trace()


def create_user(**user_data):
    user = User(**user_data)
    DBSession.add(user)
    return user
