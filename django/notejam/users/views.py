from django.contrib.auth import authenticate, login
from django.contrib.auth.models import User
from django.core.urlresolvers import reverse_lazy
from django.shortcuts import redirect
from django.views.generic.edit import FormView
from django.views.generic.edit import CreateView

from users.forms import SignupForm, SigninForm


class SignupView(CreateView):
    model = User
    form_class = SignupForm
    success_url = reverse_lazy('signin')
    # @TODO use 'template_name'


class SigninView(FormView):
    template_name = "signin.html"
    form_class = SigninForm
    success_url = reverse_lazy('home')

    def post(self, request, *args, **kwargs):
        form_class = self.get_form_class()
        form = self.get_form(form_class)
        if form.is_valid():
            user = authenticate(
                email=form.cleaned_data['email'],
                password=form.cleaned_data['password']
            )
            if user is not None:
                login(request, user)
                return redirect(reverse_lazy('home'))
            else:
                fail_message = "Wrong email or password"

            return self.render_to_response(
                self.get_context_data(form=form, fail_message=fail_message)
            )
        else:
            return self.form_invalid(form, **kwargs)


class ForgotPasswordView(FormView):
    pass


class SettingsView(FormView):
    pass
