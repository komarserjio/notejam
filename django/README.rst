******************************
Notejam: Django implementation
******************************

Notejam application implemented using Django framework.

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

    $ cd YOUR_PROJECT_DIR/django/
    $ pip install -r requirements.txt

------
Launch
------

Start django web server:

.. code-block:: bash

    $ cd YOUR_PROJECT_DIR/django/notejam/
    $ ./manage.py runserver

Go to http://127.0.0.1:8000/ in your browser

------------------
Running unit tests
------------------

Run unit tests:

.. code-block:: bash

    $ cd YOUR_PROJECT_DIR/django/notejam/
    $ ./manage.py test



============
Contribution
============

Please send your pull requests in the ``django`` branch, not ``master``.

All ways prepend your commits with a framework name:

.. code-block:: bash

    Django: Implemented sign in functionality

.. _virtualenv: http://www.virtualenv.org 
