from django.contrib.auth.models import User
from django.core.urlresolvers import reverse
from django.test import TestCase

from pads.models import Pad


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
        self.user = user

    def _create_pads(self, pads):
        return [
            (lambda pad: Pad.objects.create(name=pad, user=self.user).id)(pad)
            for pad in pads
        ]

    #def _get_pad_data(name='Pad'):
        #return {'name': name}

    def test_create_success(self):
        self.client.post(reverse('create_pad'), {'name': 'pad'})
        self.assertEquals(1, Pad.objects.count())

    def test_create_fail_required_name(self):
        response = self.client.post(reverse('create_pad'), {})
        self.assertIn('name', response.context['form'].errors)

    def test_edit_success(self):
        id = self._create_pads(['pad'])[0]
        data = {'name': 'new name'}
        response = self.client.post(reverse('edit_pad', args=(id,)), data)
        self.assertRedirects(response, reverse('view_pad_notes', args=(id,)))
        self.assertEquals(data['name'], Pad.objects.get(id=id).name)
