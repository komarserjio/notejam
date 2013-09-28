import os
import tempfile
import unittest
import urllib

from contextlib import contextmanager

from flask import url_for
from flask.ext.testing import TestCase

from notejam import app, db
from notejam.models import User, Pad, Note


class NotejamBaseTestCase(TestCase):
    def setUp(self):
        db.create_all()

    def tearDown(self):
        db.session.remove()
        db.drop_all()
        os.close(self.fd)
        os.unlink(self.db)

    def create_app(self):
        self.fd, self.db = tempfile.mkstemp()
        test_app = app
        test_app.config['SQLALCHEMY_DATABASE_URI'] = "sqlite:///" + self.db
        test_app.config['TESTING'] = True
        test_app.config['CSRF_ENABLED'] = False
        return test_app

    def create_user(self, **kwargs):
        user = User(email=kwargs['email'])
        user.set_password(kwargs['password'])
        db.session.add(user)
        db.session.commit()
        return user

    def create_pad(self, **kwargs):
        pad = Pad(**kwargs)
        db.session.add(pad)
        db.session.commit()
        return pad

    def create_note(self, **kwargs):
        note = Note(**kwargs)
        db.session.add(note)
        db.session.commit()
        return note


class SignupTestCase(NotejamBaseTestCase):
    def _get_user_data(self, **kwargs):
        user_data = {
            'email': 'email@example.com',
            'password': 'secure_password',
            'repeat_password': 'secure_password'
        }
        user_data.update(**kwargs)
        return user_data

    def test_signup_success(self):
        response = self.client.post(
            url_for("signup"), data=self._get_user_data())
        self.assertRedirects(response, url_for('signin'))
        self.assertEquals(1, User.query.count())

    def test_signup_fail_required_fields(self):
        self.client.post(url_for("signup"), data={})
        self.assertEquals(
            set(self._get_user_data().keys()),
            set(self.get_context_variable('form').errors.keys())
        )

    def test_signup_fail_email_exists(self):
        data = self._get_user_data()
        self.create_user(**data)

        self.client.post(url_for("signup"), data=self._get_user_data())
        self.assertEquals(
            ['email'], self.get_context_variable('form').errors.keys())

    def test_signup_fail_invalid_email(self):
        data = self._get_user_data()
        data['email'] = 'invalid email'

        self.client.post(url_for("signup"), data=data)
        self.assertEquals(
            ['email'], self.get_context_variable('form').errors.keys())

    def test_signup_fail_passwords_dont_match(self):
        invalid_data = self._get_user_data(password='another pass')
        self.client.post(url_for('signup'), data=invalid_data)
        self.assertEquals(
            ['repeat_password'],
            self.get_context_variable('form').errors.keys()
        )


class SigninTestCase(NotejamBaseTestCase):
    def _get_user_data(self, **kwargs):
        user_data = {
            'email': 'email@example.com',
            'password': 'secure_password'
        }
        user_data.update(**kwargs)
        return user_data

    def test_signin_success(self):
        data = self._get_user_data()
        self.create_user(**data)

        response = self.client.post(url_for('signin'), data=data)
        self.assertRedirects(response, url_for('index'))

    def test_signin_fail(self):
        response = self.client.post(
            url_for('signin'), data=self._get_user_data())
        self.assertIn('Wrong email or password', response.data)

    def test_signin_fail_required_fields(self):
        self.client.post(url_for("signin"), data={})
        self.assertEquals(
            set(self._get_user_data().keys()),
            set(self.get_context_variable('form').errors.keys())
        )

    def test_signup_fail_invalid_email(self):
        data = self._get_user_data()
        data['email'] = 'invalid email'

        self.client.post(url_for("signin"), data=data)
        self.assertEquals(
            ['email'], self.get_context_variable('form').errors.keys())


class PadTestCase(NotejamBaseTestCase):

    def test_create_success(self):
        user = self.create_user(email='email@example.com', password='password')
        with signed_in_user(user) as c:
            response = c.post(url_for('create_pad'), data={'name': 'pad'})
            self.assertRedirects(response, '/')
            self.assertEquals(1, Pad.query.count())

    def test_create_fail_required_name(self):
        user = self.create_user(email='email@example.com', password='password')
        with signed_in_user(user) as c:
            c.post(url_for('create_pad'), data={})
            self.assertEquals(
                ['name'], self.get_context_variable('form').errors.keys())

    def test_create_fail_anonymous_user(self):
        response = self.client.post(
            url_for('create_pad'), data={'name': 'pad'})
        self.assertRedirects(
            response,
            "{signin}?next={redirect_to}".format(
                signin=url_for('signin'), redirect_to=urllib.quote(
                    url_for('create_pad'), ''))
        )

    def test_edit_success(self):
        user = self.create_user(email='email@example.com', password='password')
        pad = self.create_pad(name='pad', user=user)
        with signed_in_user(user) as c:
            new_name = 'new pad name'
            response = c.post(
                url_for('update_pad', pad_id=pad.id), data={'name': new_name})
            self.assertRedirects(response, url_for('pad_notes', pad_id=pad.id))
            self.assertEquals(new_name, Pad.query.get(pad.id).name)

    def test_edit_fail_required_name(self):
        user = self.create_user(email='email@example.com', password='password')
        pad = self.create_pad(name='pad', user=user)
        with signed_in_user(user) as c:
            c.post(url_for('update_pad', pad_id=pad.id), data={'name': ''})
            self.assertEquals(
                ['name'], self.get_context_variable('form').errors.keys())

    def test_edit_fail_anothers_user(self):
        user = self.create_user(email='email@example.com', password='password')
        pad = self.create_pad(name='pad', user=user)
        another_user = self.create_user(
            email='another@example.com', password='password')
        with signed_in_user(another_user) as c:
            new_name = 'new pad name'
            response = c.post(
                url_for('update_pad', pad_id=pad.id), data={'name': new_name})
            self.assertEquals(404, response.status_code)

    def test_delete_success(self):
        user = self.create_user(email='email@example.com', password='password')
        pad = self.create_pad(name='pad', user=user)
        with signed_in_user(user) as c:
            response = c.post(
                url_for('delete_pad', pad_id=pad.id))
            self.assertRedirects(response, url_for('index'))
            self.assertEquals(0, Pad.query.count())

    def test_delete_fail_anothers_user(self):
        user = self.create_user(email='email@example.com', password='password')
        pad = self.create_pad(name='pad', user=user)
        another_user = self.create_user(
            email='another@example.com', password='password')
        with signed_in_user(another_user) as c:
            response = c.post(
                url_for('delete_pad', pad_id=pad.id))
            self.assertEquals(404, response.status_code)


class NoteTestCase(NotejamBaseTestCase):
    def _get_note_data(self, **kwargs):
        note_data = {
            'name': 'note', 'pad': 0, 'text': 'text'
        }
        note_data.update(**kwargs)
        return note_data

    def test_create_success(self):
        user = self.create_user(email='email@example.com', password='password')
        with signed_in_user(user) as c:
            response = c.post(
                url_for('create_note'), data=self._get_note_data())
            self.assertRedirects(response, '/')
            self.assertEquals(1, Note.query.count())

    def test_create_fail_required_fields(self):
        user = self.create_user(email='email@example.com', password='password')
        with signed_in_user(user) as c:
            c.post(url_for('create_note'), data={})
            self.assertEquals(
                set(self._get_note_data().keys()),
                set(self.get_context_variable('form').errors.keys())
            )

    def test_create_fail_anothers_pad(self):
        user = self.create_user(email='email@example.com', password='password')
        another_user = self.create_user(
            email='another@example.com', password='password')
        pad = self.create_pad(name='pad', user=another_user)
        with signed_in_user(user) as c:
            c.post(
                url_for('create_note'), data=self._get_note_data(pad=pad.id))
            self.assertEquals(
                ['pad'], self.get_context_variable('form').errors.keys()
            )

    def test_create_fail_anonymous_user(self):
        pass

    def test_edit_success(self):
        pass

    def test_edit_fail_required_fields(self):
        pass

    def test_edit_fail_anothers_pad(self):
        pass

    def test_edit_fail_anothers_user(self):
        pass

    def test_delete_success(self):
        pass

    def test_delete_fail_anothers_user(self):
        pass


@contextmanager
def signed_in_user(user):
    with app.test_client() as c:
        with c.session_transaction() as sess:
            sess['user_id'] = user.id
            sess['_fresh'] = True
        yield c

if __name__ == '__main__':
    unittest.main()
