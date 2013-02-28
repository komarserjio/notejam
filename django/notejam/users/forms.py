from django import forms
from django.contrib.auth.models import User


class SignupForm(forms.ModelForm):
    email = forms.EmailField()
    password = forms.CharField(widget=forms.PasswordInput())
    repeat_password = forms.CharField(widget=forms.PasswordInput())

    class Meta:
        model = User
        fields = ('email',)

    def save(self, force_insert=False, force_update=False, commit=True):
        m = super(SignupForm, self).save(commit=False)
        # username hack
        m.username = m.email
        if commit:
            m.save()
        return m


class SigninForm(forms.Form):
    email = forms.EmailField()
    password = forms.CharField(widget=forms.PasswordInput())
