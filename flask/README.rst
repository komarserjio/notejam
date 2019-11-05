**************
Notejam: Flask
**************

Notejam application implemented using `Flask <http://flask.pocoo.org/>`_ microframework.

Flask version: 0.9

Flask extension used:

* Flask-Login
* Flask-Mail
* Flask-SQLAlchemy
* Flask-Testing
* Flask-WTF

==========================
Installation and launching
==========================

-----
Clone
-----

Clone the repo:

.. code-block:: bash

    $ git clone git@github.com:komarserjio/notejam.git YOUR_PROJECT_DIR/

-------
Install
-------
Use `virtualenv <http://www.virtualenv.org>`_ or `virtualenvwrapper <http://virtualenvwrapper.readthedocs.org/>`_
for `environment management <http://docs.python-guide.org/en/latest/dev/virtualenvs/>`_.

Install dependencies:

.. code-block:: bash

    $ cd YOUR_PROJECT_DIR/flask/
    $ pip install -r requirements.txt

Create database schema:

.. code-block:: bash

    $ cd YOUR_PROJECT_DIR/flask/
    $ python db.py

------
Launch
------

Start flask web server:

.. code-block:: bash

    $ cd YOUR_PROJECT_DIR/flask/
    $ FLASK_APP=notejam FLASK_ENV=development flask run --no-reload


Go to http://127.0.0.1:5000/ in your browser

---------
Run tests
---------

Run functional and unit tests:

.. code-block:: bash

    $ cd YOUR_PROJECT_DIR/flask/
    $ python tests.py


============
Contribution
============

Do you have python/flask experience? Help the app to follow python and flask best practices.

Please send your pull requests in the ``master`` branch.
Always prepend your commits with framework name:

.. code-block:: bash

    Flask: Implemented sign in functionality

Read `contribution guide <https://github.com/komarserjio/notejam/blob/master/contribute.rst>`_ for details.
