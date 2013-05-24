from sqlalchemy import Column, Integer, String, Text

from sqlalchemy.ext.declarative import declarative_base

from sqlalchemy.orm import scoped_session, sessionmaker

from zope.sqlalchemy import ZopeTransactionExtension

DBSession = scoped_session(sessionmaker(extension=ZopeTransactionExtension()))
Base = declarative_base()


#class QueryBase(Base):
    #@classmethod
    #def query(cls):
        #return DBSession.query(cls)


class MyModel(Base):
    __tablename__ = 'models'
    id = Column(Integer, primary_key=True)
    name = Column(Text, unique=True)
    value = Column(Text)


class User(Base):
    __tablename__ = 'users'
    id = Column(Integer, primary_key=True)
    email = Column(String(120), unique=True)
    password = Column(String(36))

    def __repr__(self):
        return '<User: {}>'.format(self.email)


class Pad(object):
    pass


class Note(object):
    pass
