from flask import Blueprint, Flask
from flask.ext.sqlalchemy import SQLAlchemy
from flask.ext.login import LoginManager
from flask.ext.mail import Mail

db = SQLAlchemy()
login_manager = LoginManager()
mail = Mail()
notejam = Blueprint(__name__, __name__)

from .views import (
    load_user,
    home,
    create_note,
    edit_note,
    view_note,
    delete_note,
    create_pad,
    edit_pad,
    pad_notes,
    delete_pad,
    signin,
    signout,
    signup,
    account_settings,
    forgot_password
)

def create_app():
    app = Flask(__name__, instance_relative_config=True)

    app.config.from_object("notejam.config.DevelopmentConfig")
    app.config.from_envvar("NOTEJAM_CONFIG", silent=True)
    app.register_blueprint(notejam)
    db.init_app(app)
    login_manager.init_app(app)
    login_manager.login_view = "notejam.signin"
    mail.init_app(app)
    return app
