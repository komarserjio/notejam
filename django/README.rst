==============================
Notejam: Django implementation
==============================

Notejam application implemented using Django framework.

Installation and running
========================

Cloning
-------

Clone the repo::
    git clone git@github.com:komarserjio/notejam.git YOUR_PROJECT_DIR/

Install environment
-------------------
Using `virtualenv <http://www.virtualenv.org/>` is strongly advised.

Go to the django dir::
    $ cd YOUR_PROJECT_DIR/django/

Install dependencies::
    $ pip install -r requirements.txt

Running
-------

Start django web server::
    $ cd YOUR_PROJECT_DIR/django/notejam/
    $ ./manage.py runserver

Go to http://127.0.0.1:8000/

Running unit tests
------------------

Run unit tests::
    $ cd YOUR_PROJECT_DIR/django/notejam/
    $ ./manage.py test
