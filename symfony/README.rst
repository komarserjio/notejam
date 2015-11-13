****************
Notejam: Symfony
****************

Notejam application implemented using `Symfony <http://symfony.com>`_ framework.

Symfony version: 2.7

The application is maintained by `@aminemat <https://twitter.com/aminemat>`_.

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

    $ cd YOUR_PROJECT_DIR/symfony/notejam
    $ curl -s https://getcomposer.org/installer | php

Install dependencies

.. code-block:: bash

    $ cd YOUR_PROJECT_DIR/symfony/notejam
    $ php composer.phar install

Create database schema

.. code-block:: bash

    $ cd YOUR_PROJECT_DIR/symfony/notejam
    $ php app/console doctrine:schema:update --force


------
Launch
------

Start built-in symfony web server:

.. code-block:: bash

    $ cd YOUR_PROJECT_DIR/symfony/notejam/
    $ php app/console server:run

Go to http://localhost:8000/ in your browser.

---------
Run tests
---------

Run tests:

.. code-block:: bash

    $ cd YOUR_PROJECT_DIR/symfony/notejam/
    $ ./bin/phpunit -c app/


============
Contribution
============


Do you have php/symfony experience? Help the app to follow php and symfony best practices.

Please send your pull requests in the ``master`` branch.
Always prepend your commits with framework name:

.. code-block:: bash

    Symfony: Implemented sign in functionality

Read `contribution guide <https://github.com/komarserjio/notejam/blob/master/contribute.rst>`_ for details.
