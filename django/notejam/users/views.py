from django.contrib.auth.models import User
from django.core.urlresolvers import reverse_lazy
from django.views.generic.edit import FormView
from django.views.generic.edit import CreateView

from users.forms import SignupForm, SigninForm


class SignupView(CreateView):
    model = User
    form_class = SignupForm
    success_url = reverse_lazy('signin')
    # @TODO use 'template_name'

    #def form_invalid(self, form):
        #pass


class SigninView(FormView):
    template_name = "signin.html"
    form_class = SigninForm
    success_url = reverse_lazy('home')


class ForgotPasswordView(FormView):
    pass


class SettingsView(FormView):
    pass
