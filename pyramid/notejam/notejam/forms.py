from formencode import Schema, validators


class SignupSchema(Schema):
    allow_extra_fields = True
    filter_extra_fields = True

    email = validators.Email(not_empty=True)
    password = validators.UnicodeString(min=6)
    confirm_password = validators.UnicodeString(min=6)
    passwords_match = [
        validators.FieldsMatch('password', 'confirm_password')
    ]


class SigninSchema(Schema):
    allow_extra_fields = True
    filter_extra_fields = True

    email = validators.Email(not_empty=True)
    password = validators.UnicodeString(min=6)


class PadSchema(Schema):
    name = validators.UnicodeString(not_empty=True)


class NoteSchema(Schema):
    name = validators.UnicodeString(not_empty=True)
    text = validators.UnicodeString(not_empty=True)
    pad_id = validators.Int()
