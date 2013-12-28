from django.contrib.auth.models import User
from django.core.urlresolvers import reverse
from django.test import TestCase


class SignUpTest(TestCase):
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
            reverse('signup'), self._get_user_data())
        self.assertRedirects(response, reverse('signin'))
        self.assertEqual(1, User.objects.all().count())

    def test_signup_fail_required_fields(self):
        response = self.client.post(reverse('signup'), {})
        self.assertEqual(
            response.context['form'].errors.keys(),
            self._get_user_data().keys()
        )

    def test_signup_fail_invalid_email(self):
        invalid_data = self._get_user_data(email='invalid email')
        response = self.client.post(reverse('signup'), invalid_data)
        self.assertIn('email', response.context['form'].errors)

    def test_signup_fail_passwords_dont_match(self):
        invalid_data = self._get_user_data(password='another pass')
        response = self.client.post(reverse('signup'), invalid_data)
        self.assertIn('repeat_password', response.context['form'].errors)

    def test_signup_fail_email_exists(self):
        data = self._get_user_data()
        User.objects.create(
            email=data['email'],
            username=data['email'],
            password=data['password']
        )

        response = self.client.post(reverse('signup'), data)
        self.assertIn('email', response.context['form'].errors)


class SignInTest(TestCase):
    def _get_user_data(self, **kwargs):
        user_data = {
            'email': 'email@example.com',
            'password': 'secure_password'
        }
        user_data.update(**kwargs)
        return user_data

    def test_signin_success(self):
        data = self._get_user_data()
        user = User.objects.create(email=data['email'], username=data['email'])
        user.set_password(data['password'])
        user.save()

        response = self.client.post(reverse('signin'), data)
        self.assertRedirects(response, reverse('home'))

    def test_signin_fail(self):
        response = self.client.post(reverse('signin'), self._get_user_data())
        self.assertContains(response, 'Wrong email or password')

    def test_signin_fail_required_fields(self):
        response = self.client.post(reverse('signin'), {})
        self.assertEqual(
            response.context['form'].errors.keys(),
            self._get_user_data().keys()
        )

    def test_signin_fail_invalid_email(self):
        invalid_data = self._get_user_data(email='invalid email')
        response = self.client.post(reverse('signin'), invalid_data)
        self.assertIn('email', response.context['form'].errors)
