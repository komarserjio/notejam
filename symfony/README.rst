******************************
Notejam: Symfony implementation
******************************

Notejam application implemented using Symfony framework.

Symfony version: 2.4

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

Install composer

.. code-block:: bash

    $ curl -s https://getcomposer.org/installer | php

Install dependencies

.. code-block:: bash

    $ php composer.phar install



------
Launch
------

Start built-in symfony web server:

.. code-block:: bash

    $ cd YOUR_PROJECT_DIR/symfony/notejam/
    $ php app/console server:run

Go to http://localhost:8000/ in your browser.

------------------
Running unit tests
------------------

Run unit tests:

.. code-block:: bash

    $ cd YOUR_PROJECT_DIR/symfony/notejam/
    $ phpunit



============
Contribution
============

Are you symfony guru? You are welcomve to contribute to improve the implementation.

Please send your pull requests in the ``symfony`` branch, not ``master``.

Always prepend your commits with a framework name:

.. code-block:: bash

    Symfony: Implemented sign in functionality

Post issues into project github tracker. 

Read contribution guide for details.
