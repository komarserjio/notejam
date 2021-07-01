from django.test.simple import DjangoTestSuiteRunner
from django.conf import settings
from django.contrib.auth.models import User


EXCLUDED_APPS = getattr(settings, 'TEST_EXCLUDE', [])


# based on http://djangosnippets.org/snippets/2211/
# main approach is to ignore library tests
class AdvancedTestSuiteRunner(DjangoTestSuiteRunner):
    def __init__(self, *args, **kwargs):
        # to avoid circular import
        from django.conf import settings
        settings.TESTING = True
        super(AdvancedTestSuiteRunner, self).__init__(*args, **kwargs)

    def build_suite(self, *args, **kwargs):
        suite = super(AdvancedTestSuiteRunner, self).build_suite(*args,
                                                                 **kwargs)
        if not args[0] and not getattr(settings, 'RUN_ALL_TESTS', False):
            tests = []
            for case in suite:
                pkg = case.__class__.__module__.split('.')[0]
                if pkg not in EXCLUDED_APPS:
                    tests.append(case)
            suite._tests = tests
        return suite


# helper test functions
def create_user(user_data):
    user = User.objects.create(username=user_data['email'], **user_data)
    user.set_password(user_data['password'])
    user.save()
    return user
