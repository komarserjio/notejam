****************
Notejam: Express
****************

Notejam application implemented using `Express.js <http://expressjs.com/>`_ microframework.

Express version: 4.2

Middlewares/extentions used:

* `Passport.js <http://passportjs.org/>`_ for authentication
* `Node ORM 2 <https://github.com/dresende/node-orm2>`_ for database
* `Mocha <http://mochajs.org/>`_ and `Superagent <http://visionmedia.github.io/superagent/>`_ for testing
* ... and `others <https://github.com/komarserjio/notejam/blob/express/express/notejam/package.json>`_

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
Use `npm <https://www.npmjs.org/>`_ to manage dependencies.

Install dependencies

.. code-block:: bash

    $ cd YOUR_PROJECT_DIR/express/notejam/
    $ npm install

Create database schema

.. code-block:: bash

    $ cd YOUR_PROJECT_DIR/express/notejam/
    $ node db.js

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

.. code-block:: bash

    $ cd YOUR_PROJECT_DIR/express/notejam/
    $ ./node_modules/mocha/bin/mocha tests

============
Contribution
============

Please send your pull requests in the ``master`` branch.

Always prepend your commits with a framework name:

.. code-block:: bash

    Express: Implemented sign in functionality
