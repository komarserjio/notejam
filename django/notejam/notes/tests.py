from django.core.urlresolvers import reverse
from django.test import TestCase, Client

from notejam.tests import create_user
from notes.models import Note


class NoteTest(TestCase):
    def setUp(self):
        user_data = {
            'email': 'user@example.com',
            'password': 'secure_password'
        }
        self.user = create_user(user_data)
        self.client.login(**user_data)

    def test_create_success(self):
        self.client.post(
            reverse('create_note'), {'name': 'pad', 'text': 'pad text'})
        self.assertEquals(1, Note.objects.count())

    def test_create_fail_required_name(self):
        response = self.client.post(reverse('create_note'), {})
        self.assertEquals(
            set(['name', 'text']), set(response.context['form'].errors.keys()))
