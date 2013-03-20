from flask import Flask
from flask.ext.sqlalchemy import SQLAlchemy


app = Flask(__name__)
app.config.from_object('notejam.config')
db = SQLAlchemy(app)

from notejam import views
