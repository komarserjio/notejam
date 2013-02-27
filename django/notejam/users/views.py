from django.contrib.auth.models import User
from django.views.generic.edit import FormView
from django.views.generic.edit import CreateView


class SignupView(CreateView):
    model = User
    pass


class SigninView(FormView):
    pass


class ForgotPasswordView(FormView):
    pass


class SettingsView(FormView):
    pass
