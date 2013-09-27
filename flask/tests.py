import os
import tempfile
import unittest

from contextlib import contextmanager

from flask import url_for
from flask.ext.testing import TestCase

from notejam import app, db
from notejam.models import User, Pad


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

    def _create_user(self, email, password):
        user = User(email=email)
        user.set_password(password)
        db.session.add(user)
        db.session.commit()
        return user


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
        self._create_user(data['email'], data['password'])

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
        self._create_user(data['email'], data['password'])

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

    def _create_pad(self, pad_name, user):
        pad = Pad(name=pad_name, user=user)
        db.session.add(pad)
        db.session.commit()
        return pad

    def test_create_success(self):
        user = self._create_user('email@example.com', 'password')
        with signed_in_user(user) as c:
            response = c.post(url_for('create_pad'), data={'name': 'pad'})
            self.assertRedirects(response, '/')
            self.assertEquals(1, Pad.query.count())

    def test_create_fail_required_name(self):
        user = self._create_user('email@example.com', 'password')
        with signed_in_user(user) as c:
            c.post(url_for('create_pad'), data={})
            self.assertEquals(
                ['name'], self.get_context_variable('form').errors.keys())

    def test_edit_success(self):
        user = self._create_user('email@example.com', 'password')
        pad = self._create_pad('pad name', user)
        with signed_in_user(user) as c:
            new_name = 'new pad name'
            response = c.post(
                url_for('update_pad', pad_id=pad.id), data={'name': new_name})
            self.assertRedirects(response, url_for('pad_notes', pad_id=pad.id))
            self.assertEquals(new_name, Pad.query.get(pad.id).name)


class NoteTestCase(TestCase):
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
