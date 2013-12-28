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
        user = super(SignupForm, self).save(commit=False)
        # username hack (we don't need username, but django requires it ?)
        user.username = user.email

        user.set_password(self.cleaned_data['password'])
        if commit:
            user.save()
        return user

    def clean_email(self):
        email = self.cleaned_data.get('email')

        if User.objects.filter(email=email).count():
            raise forms.ValidationError(
                'User with this email is already signed up'
            )

        return email

    def clean_repeat_password(self):
        password = self.cleaned_data.get('password')
        repeat_password = self.cleaned_data.get('repeat_password')

        if password != repeat_password:
            raise forms.ValidationError("Your passwords do not match")


class SigninForm(forms.Form):
    email = forms.EmailField()
    password = forms.CharField(widget=forms.PasswordInput())


class ForgotPasswordForm(forms.Form):
    email = forms.EmailField()

    def clean_email(self):
        email = self.cleaned_data.get('email')
        try:
            User.objects.get(email=email)
            return email
        except User.DoesNotExist:
            raise forms.ValidationError("No user with given email")
