from django.contrib import messages
from django.contrib.auth import authenticate, login
from django.contrib.auth.forms import PasswordChangeForm
from django.contrib.auth.models import User
from django.core.urlresolvers import reverse_lazy
from django.shortcuts import redirect
from django.views.generic.edit import FormView
from django.views.generic.edit import CreateView

from users.forms import SignupForm, SigninForm, ForgotPasswordForm


class SignupView(CreateView):
    model = User
    form_class = SignupForm
    success_url = reverse_lazy('signin')
    # @TODO use 'template_name'


class SigninView(FormView):
    template_name = "signin.html"
    form_class = SigninForm
    success_url = reverse_lazy('home')
    error_message = "Wrong password or email"

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
                messages.error(request, self.error_message)

            return self.render_to_response(
                self.get_context_data(form=form)
            )
        else:
            return self.form_invalid(form, **kwargs)


class ForgotPasswordView(FormView):
    form_class = ForgotPasswordForm
    template_name = 'forgot_password.html'
    success_url = reverse_lazy('signin')
    success_message = 'Check your inbox'

    def form_valid(self, form):
        messages.success(self.request, self.success_message)
        return super(ForgotPasswordView, self).form_valid(form)


class AccountSettingsView(FormView):
    form_class = PasswordChangeForm
    template_name = 'account.html'
    success_url = reverse_lazy('home')
    success_message = 'Password is successfully changed'

    def get_form_kwargs(self):
        kwargs = super(AccountSettingsView, self).get_form_kwargs()
        kwargs['user'] = self.request.user
        return kwargs

    def form_valid(self, form):
        messages.success(self.request, self.success_message)
        return super(AccountSettingsView, self).form_valid(form)
