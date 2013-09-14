import unittest
import transaction

from pyramid import testing

from .models import DBSession


class BaseTestCase(unittest.TestCase):
    def setUp(self):
        self.config = testing.setUp()
        from sqlalchemy import create_engine
        engine = create_engine('sqlite://')
        #from .models import (
            #Base,
            #MyModel,
            #)
        #DBSession.configure(bind=engine)
        #Base.metadata.create_all(engine)
        with transaction.manager:
            pass
            #model = MyModel(name='one', value=55)
            #DBSession.add(model)

    def tearDown(self):
        DBSession.remove()
        testing.tearDown()

    def test_it(self):
        self.assertTrue(True)
        #from .views import my_view
        #request = testing.DummyRequest()
        #info = my_view(request)
        #self.assertEqual(info['one'].name, 'one')
        #self.assertEqual(info['project'], 'notejam')


class SignUpTest(unittest.TestCase):
    def test_signup_success(self):
        pass

    def test_signup_fail_required_fields(self):
        pass

    def test_signup_fail_passwords_do_not_match(self):
        pass

    def test_signup_fail_invalid_email(self):
        pass

    def test_signup_fail_email_exists(self):
        pass


class PadTest(unittest.TestCase):
    def test_create_pad_success(self):
        pass

    def test_create_pad_fail(self):
        pass


class NoteTest(unittest.TestCase):
    def test_create_note_success(self):
        pass

    def test_create_note_fail_required_fields(self):
        pass

    def test_list_all_notes(self):
        pass

    def test_list_notes_by_pad(self):
        pass
