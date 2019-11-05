from notejam import create_app, db

app = create_app()

# Create db schema
with app.app_context():
	db.create_all()
