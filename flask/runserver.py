from notejam import app
from os import environ


if __name__ == '__main__':
    app.run(host=environ.get("APP_HOST"), port=int(environ.get("APP_PORT", 5000)))
