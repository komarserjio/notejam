from django.test import TestCase
from django.core.urlresolvers import reverse_lazy
from django.contrib.auth.models import User


class SignUpTest(TestCase):
    def test_signup_success(self):
        data = {
            'email': 'email@example.com',
            'password': 'secure_password',
            'repeat_password': 'secure_password'
        }
        response = self.client.post(reverse_lazy('signup'), data)
        self.assertRedirects(response, '/signin/')
        self.assertEqual(1, User.objects.all().count())
