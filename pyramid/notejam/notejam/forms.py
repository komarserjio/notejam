from formencode import Schema, validators


class UserSchema(Schema):
    allow_extra_fields = True
    filter_extra_fields = True

    email = validators.Email(max=10)
    password = validators.UnicodeString(min=6)
    confirm_password = validators.UnicodeString(min=6)
