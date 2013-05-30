import cryptacular.bcrypt

from sqlalchemy import Column, Integer, String, Text

from sqlalchemy.ext.declarative import declarative_base

from sqlalchemy.orm import scoped_session, sessionmaker, synonym

from zope.sqlalchemy import ZopeTransactionExtension

from pyramid.security import (
    Everyone,
    Authenticated,
    Allow,
    )

DBSession = scoped_session(sessionmaker(extension=ZopeTransactionExtension()))
Base = declarative_base()

crypt = cryptacular.bcrypt.BCRYPTPasswordManager()


#class QueryBase(Base):
    #@classmethod
    #def query(cls):
        #return DBSession.query(cls)


def hash_password(password):
    return unicode(crypt.encode(password))


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


class Pad(object):
    pass


class Note(object):
    pass


# acl configuration
class RootFactory(object):
    __acl__ = [
        (Allow, Authenticated, 'login_required')
    ]

    def __init__(self, request):
        pass  # pragma: no cover
