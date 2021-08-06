****************
Notejam: Express
****************

This repo is a fork from https://github.com/komarserjio/notejam. It adds CI/CD to deploy notejam 
into multiple environments, whose infrastructure is orchestrated via Terraform. 

Notejam is an application implemented using `Express.js <http://expressjs.com/>`_ microframework.

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

    $ git clone https://github.com/binte/notejam.git YOUR_PROJECT_DIR/

-------------------
Install environment
-------------------
Use `npm <https://www.npmjs.org/>`_ to manage dependencies.

Install dependencies

.. code-block:: bash

    $ cd YOUR_PROJECT_DIR/expressApp
    $ npm install (or npm ci)

Create database schema

.. code-block:: bash

    $ cd YOUR_PROJECT_DIR/expressApp
    $ node db.js (or run db)

------
Launch
------

Start built-in web server:

.. code-block:: bash

    $ cd YOUR_PROJECT_DIR/expressApp
    $ node ./bin/www (or run start)

Go to http://127.0.0.1:3000/ in your browser

------------------
Running unit tests
------------------

Run unit tests:

.. code-block:: bash

    $ cd YOUR_PROJECT_DIR/expressApp
    $ ./node_modules/mocha/bin/_mocha tests (or run test)

============
Contribution
============

Please send your pull requests in the ``master`` branch.
