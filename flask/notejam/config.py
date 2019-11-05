import os


basedir = os.path.abspath(os.path.dirname(__file__))

class Config(object):
    SECRET_KEY = 'notejam-flask-secret-key'
    CSRF_ENABLED = True
    SQLALCHEMY_DATABASE_URI = 'sqlite:///' + os.path.join(basedir, 'notejam.db')
    SQLALCHEMY_TRACK_MODIFICATIONS = False


class DevelopmentConfig(Config):
    DEBUG = True
    CSRF_ENABLED = False


class TestingConfig(DevelopmentConfig):
    TESTING = True
    PRESERVE_CONTEXT_ON_EXCEPTION = False
    SQLALCHEMY_DATABASE_URI = 'sqlite:///:memory:'
