***************
Notejam: Django
***************

Notejam application implemented using `Django <https://www.djangoproject.com/>`_ framework.

Django version: 1.6

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

    $ cd YOUR_PROJECT_DIR/django/
    $ pip install -r requirements.txt

Create database schema:

.. code-block:: bash

    $ cd YOUR_PROJECT_DIR/django/notejam/
    $ ./manage.py syncdb
    $ ./manage.py migrate

------
Launch
------

Start django web server:

.. code-block:: bash

    $ cd YOUR_PROJECT_DIR/django/notejam/
    $ ./manage.py runserver

Go to http://127.0.0.1:8000/ in your browser.

---------
Run tests
---------

Run functional and unit tests:

.. code-block:: bash

    $ cd YOUR_PROJECT_DIR/django/notejam/
    $ ./manage.py test


============
Contribution
============
Do you have python/django experience? Help the app to follow python and django best practices.

Please send your pull requests in the ``master`` branch.
Always prepend your commits with framework name:

.. code-block:: bash

    Django: Implemented sign in functionality

Read `contribution guide <https://github.com/komarserjio/notejam/blob/master/contribute.rst>`_ for details.
