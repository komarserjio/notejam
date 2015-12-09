**************
Notejam: Nette
**************

Notejam application implemented using `Nette framework <https://nette.org>`_.

Nette version: 2.3

The application is maintained by `@klimesf <https://github.com/klimesf>`_.

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

    $ cd YOUR_PROJECT_DIR/nette/native_db/notejam
    $ curl -s https://getcomposer.org/installer | php

Install dependencies

.. code-block:: bash

    $ cd YOUR_PROJECT_DIR/nette/native_db/notejam
    $ php composer.phar install

Create your copy of ``config.local.neon``

.. code-block:: bash

    $ cd YOUR_PROJECT_DIR/nette/native_db/notejam
    $ cp app/config/config.example.neon app/config/config.local.neon

Create database schema

.. code-block:: bash

    $ cd YOUR_PROJECT_DIR/nette/native_db/notejam
    $ php ./bin/create-db.php


------
Launch
------

Start built-in php web server:

.. code-block:: bash

    $ cd YOUR_PROJECT_DIR/nette/native_db/notejam/www/
    $ php -t `pwd` -S 127.0.0.1:8000 `pwd`/index.php

Go to http://localhost:8000/ in your browser.

---------
Run tests
---------

Run tests:

.. code-block:: bash

    $ cd YOUR_PROJECT_DIR/nette/native_db/notejam/www/
    $ php -t `pwd` -S 127.0.0.1:8000 `pwd`/index.php
    $ cd ../
    $ ./vendor/bin/codecept run


============
Contribution
============


Do you have php/nette experience? Help the app to follow php and Nette Framework best practices.

Please send your pull requests in the ``master`` branch.
Always prepend your commits with framework name:

.. code-block:: bash

    Nette: Implemented sign in functionality

Read `contribution guide <https://github.com/komarserjio/notejam/blob/master/contribute.rst>`_ for details.
