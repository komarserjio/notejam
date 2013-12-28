from formencode import Schema, validators, FancyValidator, All, Invalid

from models import DBSession, User


class UniqueEmail(FancyValidator):
    def to_python(self, value, state):
        if DBSession.query(User).filter(User.email == value).count():
            raise Invalid(
                'That email already exists', value, state
            )
        return value


class EmailExists(FancyValidator):
    def to_python(self, value, state):
        if not DBSession.query(User).filter(User.email == value).count():
            raise Invalid(
                'That email doesnt exist', value, state
            )
        return value


class PasswordCorrect(FancyValidator):
    def to_python(self, value, state):
        if not state.user.check_password(value):
            raise Invalid(
                'Current password is not correct', value, state
            )
        return value


class OneOfPad(FancyValidator):
    def to_python(self, value, state):
        value = int(value)
        if value != 0 and value not in [p.id for p in state.user.pads.all()]:
            raise Invalid(
                'Selected pad is not correct', value, state
            )
        return value


class SignupSchema(Schema):
    allow_extra_fields = True
    filter_extra_fields = True

    email = All(UniqueEmail(), validators.Email(not_empty=True))
    password = validators.UnicodeString(min=6)
    confirm_password = validators.UnicodeString(min=6)
    chained_validators = [
        validators.FieldsMatch('password', 'confirm_password')
    ]


class SigninSchema(Schema):
    allow_extra_fields = True
    filter_extra_fields = True

    email = validators.Email(not_empty=True)
    password = validators.UnicodeString(min=6)


class PadSchema(Schema):
    allow_extra_fields = True

    name = validators.UnicodeString(not_empty=True)


class NoteSchema(Schema):
    allow_extra_fields = True

    name = validators.UnicodeString(not_empty=True)
    text = validators.UnicodeString(not_empty=True)
    pad_id = OneOfPad()


class ForgotPasswordSchema(Schema):
    allow_extra_fields = False

    email = All(EmailExists(), validators.Email(not_empty=True))


class ChangePasswordSchema(Schema):
    allow_extra_fields = False

    old_password = All(PasswordCorrect(), validators.UnicodeString(min=6))
    password = validators.UnicodeString(min=6)
    confirm_password = validators.UnicodeString(min=6)
    passwords_match = [
        validators.FieldsMatch('password', 'confirm_password')
    ]
