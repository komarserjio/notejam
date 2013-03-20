from flask.ext.wtf import Form, TextField, PasswordField
from flask.ext.wtf import Required, Email


class SigninForm(Form):
    email = TextField('email', validators=[Required(), Email()])
    password = PasswordField('password', validators=[Required()])
