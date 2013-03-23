from flask.ext.wtf import Form, TextField, PasswordField
from flask.ext.wtf import Required, Email, EqualTo, ValidationError

from notejam.models import User


class SigninForm(Form):
    email = TextField('email', validators=[Required(), Email()])
    password = PasswordField('password', validators=[Required()])


class SignupForm(Form):
    email = TextField('email', validators=[Required(), Email()])
    password = PasswordField('password', validators=[Required()])
    repeat_password = PasswordField(
        'repeat_password',
        validators=[
            Required(), EqualTo(
                'password', message="Your passwords doesn't match"
            )
        ]
    )

    def validate_email(self, field):
        if User.query.filter_by(email=field.data).count():
            raise ValidationError(
                'User with this email is already signed up'
            )
