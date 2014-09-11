****************
Notejam: Laravel
****************

Notejam application implemented using `Laravel <http://laravel.com/>`_ framework.

Laravel version: 4.1


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

Install `composer <https://getcomposer.org/>`_

.. code-block:: bash

    $ cd YOUR_PROJECT_DIR/laravel/notejam/
    $ curl -s https://getcomposer.org/installer | php

Install dependencies

.. code-block:: bash

    $ cd YOUR_PROJECT_DIR/laravel/notejam/
    $ php composer.phar install

Create database schema

.. code-block:: bash

    $ cd YOUR_PROJECT_DIR/laravel/notejam/
    $ touch app/database/notejam.db
    $ php artisan migrate


------
Launch
------

Start laravel web server:

.. code-block:: bash

    $ cd YOUR_PROJECT_DIR/laravel/notejam/
    $ php artisan serve

Go to http://localhost:8000/ in your browser.

---------
Run tests
---------

Run functional and unit tests:

.. code-block:: bash

    $ cd YOUR_PROJECT_DIR/laravel/notejam/
    $ php vendor/bin/phpunit



============
Contribution
============

Do you have php/laravel experience? Help the app to follow php and laravel best practices.

Please send your pull requests in the ``master`` branch.
Always prepend your commits with framework name:

.. code-block:: bash

    Laravel: Implemented sign in functionality

Read `contribution guide <https://github.com/komarserjio/notejam/blob/master/contribute.rst>`_ for details.
