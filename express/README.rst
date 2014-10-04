****************
Notejam: Express
****************

Notejam application implemented using `Express.js<http://expressjs.com/>`_ microframework.

Extenstions used:

* Passport.js for authentication
* Node ORM 2 for database interaction
* connect-flash for flash messages

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

TBD

------
Launch
------

Start built-in web server:

.. code-block:: bash

    $ cd YOUR_PROJECT_DIR/express/notejam/
    $ DEBUG=* ./bin/www

Go to http://127.0.0.1:3000/ in your browser

------------------
Running unit tests
------------------

Run unit tests:

TBD

============
Contribution
============

Please send your pull requests in the ``master`` branch.

Always prepend your commits with a framework name:

.. code-block:: bash

    Express: Implemented sign in functionality
