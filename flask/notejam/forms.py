from flask_wtf import FlaskForm
from wtforms import StringField, PasswordField, SelectField, TextAreaField
from wtforms.validators import Required, Email, EqualTo, ValidationError

from notejam.models import User, Pad


class SigninForm(FlaskForm):
    email = StringField('Email', validators=[Required(), Email()])
    password = PasswordField('Password', validators=[Required()])


class SignupForm(FlaskForm):
    email = StringField('Email', validators=[Required(), Email()])
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


class NoteForm(FlaskForm):
    name = StringField('Name', validators=[Required()])
    text = TextAreaField('Note', validators=[Required()])
    pad = SelectField('Pad', choices=[], coerce=int)

    # @TODO use wtforms.ext.sqlalchemy.fields.QuerySelectField?
    def __init__(self, user=None, **kwargs):
        super(NoteForm, self).__init__(**kwargs)
        self.pad.choices = [(0, '---------')] + [
            (p.id, p.name) for p in Pad.query.filter_by(user=user)
        ]


class PadForm(FlaskForm):
    name = StringField('Name', validators=[Required()])


# dummy form
class DeleteForm(FlaskForm):
    pass


class ChangePasswordForm(FlaskForm):
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


class ForgotPasswordForm(FlaskForm):
    email = StringField('Email', validators=[Required(), Email()])

    def validate_email(self, field):
        if not User.query.filter_by(email=field.data).count():
            raise ValidationError(
                'No user with given email found'
            )
