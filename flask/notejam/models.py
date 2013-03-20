from notejam import db


class User(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    email = db.Column(db.String(120), unique=True)
    password = db.Column(db.String(36))
    first_name = db.Column(db.String(120))
    last_name = db.Column(db.String(120))

    def __repr__(self):
        return '<User %r>' % self.emai
