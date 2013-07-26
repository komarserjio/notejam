import datetime
import cryptacular.bcrypt

from sqlalchemy import Column, Integer, String, Text, ForeignKey, DateTime

from sqlalchemy.ext.declarative import declarative_base

from sqlalchemy.orm import (scoped_session, sessionmaker, synonym, relation,
backref)

from zope.sqlalchemy import ZopeTransactionExtension

from pyramid.security import Authenticated, Allow

DBSession = scoped_session(sessionmaker(extension=ZopeTransactionExtension()))
Base = declarative_base()

crypt = cryptacular.bcrypt.BCRYPTPasswordManager()


def hash_password(password):
    return unicode(crypt.encode(password))


class TimestampMixin(object):
    created_at = Column(DateTime, default=datetime.datetime.now())
    updated_at = Column(
        DateTime, default=datetime.datetime.now(),
        onupdate=datetime.datetime.now()
    )


class User(Base):
    __tablename__ = 'users'
    id = Column(Integer, primary_key=True)
    email = Column(String(120), unique=True)
    _password = Column(String(36))

    def _set_password(self, password):
        self._password = hash_password(password)

    def _get_password(self):
        return self._password

    password = synonym(
        '_password', descriptor=property(_get_password, _set_password)
    )

    def __repr__(self):
        return '<User: {}>'.format(self.email)

    def check_password(self, password):
        return crypt.check(self.password, password)


class Pad(TimestampMixin, Base):
    __tablename__ = 'pads'
    id = Column(Integer, primary_key=True)
    name = Column(String(100))

    user_id = Column(Integer, ForeignKey('users.id'))
    user = relation(
        'User',
        backref=backref('pads', lazy='dynamic', cascade='all')
    )

    def __repr__(self):
        return '<Pad %r>' % self.name

    def __str__(self):
        return self.name


class Note(TimestampMixin, Base):
    __tablename__ = 'notes'
    id = Column(Integer, primary_key=True)
    name = Column(String(100))
    text = Column(Text())

    user_id = Column(Integer, ForeignKey('users.id'))
    user = relation(
        'User',
        backref=backref('notes', lazy='dynamic', cascade='all')
    )

    pad_id = Column(Integer, ForeignKey('pads.id'))
    pad = relation(
        'Pad',
        backref=backref('notes', lazy='dynamic', cascade='all')
    )

    def __repr__(self):
        return '<Note %r>' % self.name

    def __str__(self):
        return self.name


# acl configuration
class RootFactory(object):
    __acl__ = [
        (Allow, Authenticated, 'login_required')
    ]

    def __init__(self, request):
        pass  # pragma: no cover
