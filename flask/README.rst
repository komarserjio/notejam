**************************
Notejam: Flask application
**************************

Notejam application implemented using `Flask`_ microframework.

Flask extension used:

* Flask-Login
* Flask-Mail
* Flask-SQLAlchemy
* Flask-Testing
* Flask-WTF

==========================
Installation and launching
==========================

-------
Cloning
-------

Clone the repo:

.. code-block:: bash

    $ git clone git@github.com:komarserjio/notejam.git YOUR_PROJECT_DIR/

-------------------
Install environment
-------------------
Using `virtualenv`_ is strongly advised.

Install dependencies:

.. code-block:: bash

    $ cd YOUR_PROJECT_DIR/flask/
    $ pip install -r requirements.txt

------
Launch
------

Start flask web server:

.. code-block:: bash

    $ cd YOUR_PROJECT_DIR/flask/
    $ ./runserver.py

Go to http://127.0.0.1:5000/ in your browser

------------------
Running unit tests
------------------

Run unit tests:

.. code-block:: bash

    $ cd YOUR_PROJECT_DIR/flask/
    $ python tests.py

.. _virtualenv: http://www.virtualenv.org 
.. _Flask: http://flask.pocoo.org/
