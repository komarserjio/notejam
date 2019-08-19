import os
basedir = os.path.abspath(os.path.dirname(__file__))
DB_HOST = os.getenv('MYSQL_HOST', 'localhost:3306')
DB_NAME = os.getenv('MYSQL_DATABASE', 'notejam')
DB_USER = os.getenv('MYSQL_USER', 'nj')
DB_PASSWORD = os.getenv('MYSQL_PASSWORD', 'password')

class Config(object):
    DEBUG = False
    TESTING = False
    SECRET_KEY = 'notejam-flask-secret-key'
    CSRF_ENABLED = True
    CSRF_SESSION_KEY = 'notejam-flask-secret-key'
    SQLALCHEMY_DATABASE_URI = "mysql://%s:%s@%s/%s" % (DB_USER, DB_PASSWORD, DB_HOST, DB_NAME)


class ProductionConfig(Config):
    DEBUG = False


class DevelopmentConfig(Config):
    DEVELOPMENT = True
    DEBUG = True


class TestingConfig(Config):
    TESTING = True
