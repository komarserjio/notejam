from django.contrib.auth.models import User
from django.views.generic.edit import FormView
from django.views.generic.edit import CreateView

from users.forms import SignupForm


class SignupView(CreateView):
    model = User
    form_class = SignupForm
    success_url = '/'

    def form_valid(self, form):
        pass

    def form_invalid():
        pass


class SigninView(FormView):
    pass


class ForgotPasswordView(FormView):
    pass


class SettingsView(FormView):
    pass
