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
        self.assertEqual(1, Note.objects.count())

    def test_create_fail_required_fields(self):
        response = self.client.post(reverse('create_note'), {})
        self.assertEqual(
            set(['name', 'text']), set(response.context['form'].errors.keys()))

    def test_edit_success(self):
        note_data = {
            'name': 'note name',
            'text': 'note text'
        }
        note = Note.objects.create(user=self.user, **note_data)

        note_data['name'] = 'new name'
        response = self.client.post(
            reverse('edit_note', args=(note.id,)), note_data)
        self.assertRedirects(response, reverse('home'))
        self.assertEqual(note_data['name'], Note.objects.get(id=note.id).name)

    def test_another_user_cant_edit(self):
        user_data = {
            'email': 'another_user@example.com',
            'password': 'another_secure_password'
        }
        create_user(user_data)

        note_data = {
            'name': 'note name',
            'text': 'note text'
        }
        note = Note.objects.create(user=self.user, **note_data)

        client = Client()
        client.login(**user_data)
        response = client.post(reverse('edit_note', args=(note.id,)), {})
        self.assertEqual(404, response.status_code)

    def test_view_success(self):
        note_data = {
            'name': 'note name',
            'text': 'note text'
        }
        note = Note.objects.create(user=self.user, **note_data)
        response = self.client.get(reverse('view_note', args=(note.id,)), {})
        self.assertEqual(note, response.context['note'])

    def test_another_user_cant_view(self):
        user_data = {
            'email': 'another_user@example.com',
            'password': 'another_secure_password'
        }
        create_user(user_data)

        note_data = {
            'name': 'note name',
            'text': 'note text'
        }
        note = Note.objects.create(user=self.user, **note_data)

        client = Client()
        client.login(**user_data)
        response = client.get(reverse('view_note', args=(note.id,)), {})
        self.assertEqual(404, response.status_code)

    def test_delete_success(self):
        note_data = {
            'name': 'note name',
            'text': 'note text'
        }
        note = Note.objects.create(user=self.user, **note_data)
        self.client.post(reverse('delete_note', args=(note.id,)), {})
        self.assertEqual(0, Note.objects.count())

    def test_another_user_cant_delete(self):
        user_data = {
            'email': 'another_user@example.com',
            'password': 'another_secure_password'
        }
        create_user(user_data)

        note_data = {
            'name': 'note name',
            'text': 'note text'
        }
        note = Note.objects.create(user=self.user, **note_data)

        client = Client()
        client.login(**user_data)
        response = client.get(reverse('view_note', args=(note.id,)), {})
        self.assertEqual(404, response.status_code)
