# Notejam: dogeweb

Notejam application implemented using [dogeweb](http://pyos.github.io/dogeweb/) async microframework.

Other modules used:

  * [dg](http://pyos.github.io/dg/)
  * [Jinja2](http://jinja.pocoo.org/docs/)
  * [jinja-hamlike](https://github.com/pyos/jinja-hamlike)
  * [itsdangerous](http://pythonhosted.org/itsdangerous/)
  * [hoep](https://github.com/Anomareh/Hoep)
  * [Pygments](http://pygments.org/)
  * [SQLAlchemy](http://www.sqlalchemy.org/)

## Differences from the original implementation

### Design

This implementation uses [Bootstrap](http://getbootstrap.com/) as a basis for all templates.
Most pages look slightly different as a result. In addition to that, this implementation
boasts custom error pages and fancy JavaScript-powered forms.

### Route layout

Some routes were combined to simplify the routing tree. Here's the complete list of routes:

  * `GET  /` — the list of all notes;
  * `POST /` — create a new note;
  * `GET  /notes/<int:note_id>/` ­— view a single note;
  * `POST /notes/<int:note_id>/` — edit an existing note;
  * `GET  /notes/<int:note_id>/delete/` — remove an existing note;
  * `GET  /pads/<int:pad_id>/` — view notes assigned to a given pad;
  * `POST /pads/<int:pad_id>/` — change the name of a pad;
  * `GET    /me/` — display the password change form;
  * `POST   /me/` — sign in, optionally changing the password;
  * `PUT    /me/` — sign up;
  * `FORGOT /me/` — generate a new password & send an e-mail.
  * `GET    /me/logout` ­— logout.

Note that there are no routes to create/remove pads. A pad exists as long as at least one
note is assigned to it.

### JSON

Any page can be requested with `Accept: application/json` to receive data in JSON. The schemas:

  * `GET /` — `{"notes": [Note], "pads": [Pad]}`
  * `GET /notes/<int:note_id>/` — `Note`
  * `GET /pads/<int:pad_id>/` — `{"notes": [Note], "pad": Pad}`
  * `GET /me/` — `{"email": str, "id": int}`

where

```javascript
Pad  = {"id": int, "name": str}
Note = {"id": int, "name": str, "time": int, "text": str, "html": str, "pad": Pad}
```

All other routes either redirect somewhere or return an appropriate HTTP error.
Errors are returned as `{"code": int, "name": str, "description": str}` objects.

### Markdown

Notes are Markdown-formatted, not plaintext. Not much else to say.

## Note: smtplib is synchronous

Therefore, the application will block while someone is being reminded of their password.
The correct fix to this problem is to use an [asyncio](https://docs.python.org/3/library/asyncio.html)-compatible
SMTP library, of which there are (likely) none.

## Installation and launching

### Clone

```bash
$ git clone https://github.com/komarserjio/notejam.git
```

### Install

Use [virtualenv](http://www.virtualenv.org) or [virtualenvwrapper](http://virtualenvwrapper.readthedocs.org/)
for [environment management](http://docs.python-guide.org/en/latest/dev/virtualenvs/).

Install dependencies:

```bash
$ cd notejam/dogeweb
$ pip install -r requirements.txt
```

### Launch

Start the dev server:

```bash
$ cd notejam/dogeweb
$ python3 -m notejam
```

Then go to http://127.0.0.1:8000/ in your browser

### Run tests

Run functional and unit tests:

```bash
$ cd noteham/dogeweb
$ python -m dg tests.dg
```

## Contribution

Do you have dg/dogeweb experience? (Probably not.) Help the app to follow dg and dogeweb best practices.

Please send your pull requests in the `dogeweb` branch, not `master`.
Always prepend your commits with framework name:

```
dogeweb: Implemented sign in functionality
```

Read the [contribution guide](https://github.com/komarserjio/notejam/blob/master/contribute.rst) for details.
