from flask.ext.wtf import Form, TextField, PasswordField
from flask.ext.wtf import Required, Email


class SigninForm(Form):
    email = TextField('email', validators=[Required(), Email()])
    password = PasswordField('password', validators=[Required()])


class SignupForm(Form):
    email = TextField('email', validators=[Required(), Email()])
    password = PasswordField('password', validators=[Required()])
    repeat_password = PasswordField('repeat_password', validators=[Required()])
