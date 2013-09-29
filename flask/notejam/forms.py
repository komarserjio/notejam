from flask.ext.wtf import (Form, TextField, PasswordField,
SelectField, TextAreaField)
from flask.ext.wtf import Required, Email, EqualTo, ValidationError

from notejam.models import User, Pad


class SigninForm(Form):
    email = TextField('Email', validators=[Required(), Email()])
    password = PasswordField('Password', validators=[Required()])


class SignupForm(Form):
    email = TextField('Email', validators=[Required(), Email()])
    password = PasswordField('Password', validators=[Required()])
    repeat_password = PasswordField(
        'Repeat Password',
        validators=[
            Required(), EqualTo(
                'password', message="Your passwords do not match"
            )
        ]
    )

    def validate_email(self, field):
        if User.query.filter_by(email=field.data).count():
            raise ValidationError(
                'User with this email is already signed up'
            )


class NoteForm(Form):
    name = TextField('Name', validators=[Required()])
    text = TextAreaField('Note', validators=[Required()])
    pad = SelectField('Pad', choices=[], coerce=int)

    # @TODO use wtforms.ext.sqlalchemy.fields.QuerySelectField?
    def __init__(self, user=None, **kwargs):
        super(NoteForm, self).__init__(**kwargs)
        self.pad.choices = [(0, '---------')] + [
            (p.id, p.name) for p in Pad.query.filter_by(user=user)
        ]


class PadForm(Form):
    name = TextField('Name', validators=[Required()])


# dummy form
class DeleteForm(Form):
    pass


class ChangePasswordForm(Form):
    old_password = PasswordField('Old Password', validators=[Required()])
    new_password = PasswordField('New Password', validators=[Required()])
    repeat_new_password = PasswordField(
        'Repeat New Password',
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


class ForgotPasswordForm(Form):
    email = TextField('Email', validators=[Required(), Email()])

    def validate_email(self, field):
        if not User.query.filter_by(email=field.data).count():
            raise ValidationError(
                'No user with given email found'
            )
