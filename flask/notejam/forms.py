from flask.ext.wtf import (Form, TextField, PasswordField,
SelectField, TextAreaField)
from flask.ext.wtf import Required, Email, EqualTo, ValidationError

from notejam.models import User, Pad


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


class NoteForm(Form):
    name = TextField('name', validators=[Required()])
    text = TextAreaField('text', validators=[Required()])
    pad = SelectField('pad', choices=[], coerce=int)

    # @TODO use wtforms.ext.sqlalchemy.fields.QuerySelectField
    def __init__(self, user=None, **kwargs):
        super(NoteForm, self).__init__(**kwargs)
        self.pad.choices = [(0, '---------')] + [
            (p.id, p.name) for p in Pad.query.filter_by(user=user)
        ]


class PadForm(Form):
    name = TextField('name', validators=[Required()])


# dummy form
class DeleteForm(Form):
    pass


class ChangePasswordForm(Form):
    old_password = PasswordField('old_password', validators=[Required()])
    new_password = PasswordField('new_password', validators=[Required()])
    repeat_new_password = PasswordField(
        'repeat_new_password',
        validators=[
            Required(), EqualTo(
                'new_password', message="Your passwords don't match"
            )
        ]
    )

    def __init__(self, **kwargs):
        super(ChangePasswordForm, self).__init__(**kwargs)
        self.user = kwargs['user']

    def validate_old_password(self, field):
        if not self.user.check_password(field.data):
            raise ValidationError(
                'Incorrect old password'
            )
