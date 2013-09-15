==============================
Notejam: Django implementation
==============================

Notejam application implemented using Django framework.

Installation and running
========================

Cloning
-------

Clone the repo:
.. code-block:: bash
    $ git clone git@github.com:komarserjio/notejam.git YOUR_PROJECT_DIR/

Install environment
-------------------
Using `virtualenv`_ is strongly advised.

Install dependencies:
.. code-block:: bash
    $ cd YOUR_PROJECT_DIR/django/
    $ pip install -r requirements.txt

Running
-------

Start django web server:
.. code-block:: bash
    $ cd YOUR_PROJECT_DIR/django/notejam/
    $ ./manage.py runserver

Go to http://127.0.0.1:8000/

Running unit tests
------------------

Run unit tests:
.. code-block:: bash
    $ cd YOUR_PROJECT_DIR/django/notejam/
    $ ./manage.py test

.. _virtualenv: http://www.virtualenv.org 
