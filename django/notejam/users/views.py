from django.views.generic.edit import FormView
from django.views.generic.edit import CreateView


class SignupView(CreateView):
    pass


class SigninView(FormView):
    pass


class ForgotPasswordView(FormView):
    pass
