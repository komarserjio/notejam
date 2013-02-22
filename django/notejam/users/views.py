from django.views.generic.edit import FormMixin
from django.views.generic.edit import CreateView


class SignupView(CreateView):
    pass


class SigninView(FormMixin):
    pass
