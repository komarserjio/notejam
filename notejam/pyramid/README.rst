****************
Notejam: Pyramid
****************

Notejam application implemented using `Pyramid <http://www.pylonsproject.org/>`_ framework.

Pyramid version: 1.5

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

    $ cd YOUR_PROJECT_DIR/pyramid/
    $ python setup.py develop

Create database schema:

.. code-block:: bash

    $ cd YOUR_PROJECT_DIR/pyramid/
    $ initialize_notejam_db development.ini

------
Launch
------

Start pyramid web server:

.. code-block:: bash

    $ cd YOUR_PROJECT_DIR/pyramid/
    $ pserve development.ini --reload

Go to http://127.0.0.1:6543/ in your browser

---------
Run tests
---------

Run functional and unit tests:

.. code-block:: bash

    $ cd YOUR_PROJECT_DIR/pyramid/
    $ python setup.py test

============
Contribution
============

Do you have python/pyramid experience? Help the app to follow python and pyramid best practices.

Please send your pull requests in the ``master`` branch.
Always prepend your commits with framework name:

.. code-block:: bash

    Pyramid: Implemented sign in functionality

Read `contribution guide <https://github.com/komarserjio/notejam/blob/master/contribute.rst>`_ for details.
