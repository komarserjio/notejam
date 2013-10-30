****************************
Notejam: Pyramid application
****************************

Notejam application implemented using `Pyramid`_ framework.

Pyramid version: 1.5

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

    $ cd YOUR_PROJECT_DIR/pyramid/
    $ python setup.py develop

---------
Launching
---------

Start flask web server:

.. code-block:: bash

    $ cd YOUR_PROJECT_DIR/pyramid/
    $ pserve development.ini --reload

Go to http://127.0.0.1:6543/ in your browser

-------------
Running tests
-------------

Run unit tests:

.. code-block:: bash

    $ cd YOUR_PROJECT_DIR/flask/
    $ python setup.py test

============
Contribution
============

Please send your pull requests in the ``pyramid`` branch, not ``master``.

Always prepend your commits with a framework name:

.. code-block:: bash

    Pyramid: Implemented sign in functionality


.. _virtualenv: http://www.virtualenv.org 
.. _Pyramid: http://www.pylonsproject.org
