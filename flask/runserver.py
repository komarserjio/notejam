from notejam import app
from notejam.config import DevelopmentConfig

app.config.from_object(DevelopmentConfig)

if __name__ == '__main__':
    app.run()
