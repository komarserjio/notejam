import os
import tempfile
import unittest

from flask import url_for
from flask.ext.testing import TestCase

from notejam import app, db
from notejam.models import User


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

    def create_user(self, email, password):
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

    def test_signup_fail_invalid_email(self):
        data = self._get_user_data()
        self.create_user(data['email'], data['password'])

        self.client.post(url_for("signup"), data=self._get_user_data())
        self.assertEquals(
            ['email'], self.get_context_variable('form').errors.keys())

    def test_signup_fail_email_exists(self):
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


class SigninTestCase(TestCase):
    pass


class PadTestCase(TestCase):
    pass


class NoteTestCase(TestCase):
    pass


if __name__ == '__main__':
    unittest.main()
