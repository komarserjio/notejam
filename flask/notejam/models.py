import datetime

from werkzeug.security import (generate_password_hash,
check_password_hash)
from flask_login import UserMixin

from notejam import db


class User(db.Model, UserMixin):
    id = db.Column(db.Integer, primary_key=True)
    email = db.Column(db.String(120), unique=True)
    password = db.Column(db.String(100))

    @staticmethod
    def authenticate(email, password):
        user = User.query.filter_by(email=email).first()
        if user and user.check_password(password):
            return user

    def set_password(self, password):
        self.password = generate_password_hash(password)

    def check_password(self, password):
        return check_password_hash(self.password, password)

    def __repr__(self):
        return '<User %r>' % self.email


class Note(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    name = db.Column(db.String(100))
    text = db.Column(db.Text)
    created_at = db.Column(db.DateTime, default=datetime.datetime.now)
    updated_at = db.Column(
        db.DateTime,
        default=datetime.datetime.now,
        onupdate=datetime.datetime.now
    )

    user_id = db.Column(db.Integer, db.ForeignKey('user.id'))
    user = db.relationship('User', backref=db.backref('notes', lazy='dynamic'))

    pad_id = db.Column(db.Integer, db.ForeignKey('pad.id'))
    pad = db.relationship(
        'Pad',
        backref=db.backref('notes', lazy='dynamic', cascade='all')
    )

    def __repr__(self):
        return '<Note %r>' % self.name


class Pad(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    name = db.Column(db.String(100))

    user_id = db.Column(db.Integer, db.ForeignKey('user.id'))
    user = db.relationship(
        'User',
        backref=db.backref('pads', lazy='dynamic', cascade='all')
    )

    def __repr__(self):
        return '<Pad %r>' % self.name
