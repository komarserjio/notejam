from django.contrib.auth.models import User
from django.core.urlresolvers import reverse
from django.test import TestCase


class PadTest(TestCase):
    def setUp(self):
        user_data = {
            'email': 'user@example.com',
            'password': 'secure_password'
        }
        user = User.objects.create(username=user_data['email'], **user_data)
        user.set_password(user_data['password'])
        user.save()

        self.client.login(**user_data)

    def _get_pad_data(self):
        pass

    def test_create_pad_success(self):
        pass
