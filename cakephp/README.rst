****************
Notejam: CakePHP
****************

Notejam application implemented using `CakePHP <http://www.cakephp.org/>`_ framework.

CakePHP version: 3.1

PHP version required: 5.5+

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

    $ cd YOUR_PROJECT_DIR/cakephp/notejam
    $ curl -s https://getcomposer.org/installer | php

Install dependencies

.. code-block:: bash

    $ cd YOUR_PROJECT_DIR/cakephp/notejam
    $ php composer.phar install

Create database schema

.. code-block:: bash

    $ cd YOUR_PROJECT_DIR/cakephp/notejam
    $ ./bin/cake migrations migrate


------
Launch
------

Start built-in php web server:

.. code-block:: bash

    $ cd YOUR_PROJECT_DIR/cakephp/notejam
    $ ./bin/cake server

Go to http://localhost:8765 in your browser.

---------
Run tests
---------

Run functional tests:

.. code-block:: bash

    $ cd YOUR_PROJECT_DIR/cakephp/notejam/
    $ ./vendor/bin/phpunit


============
Contribution
============
Do you have CakePHP experience? Help the app to follow PHP and CakePHP best practices.

Please send your pull requests in the ``master`` branch.
Always prepend your commits with framework name:

.. code-block:: bash

    CakePHP: Implemented sign in functionality

Read `contribution guide <https://github.com/komarserjio/notejam/blob/master/contribute.rst>`_ for details.
