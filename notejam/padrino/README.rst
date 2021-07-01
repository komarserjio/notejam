****************
Notejam: Padrino
****************

Notejam application implemented using `Padrino <http://www.padrinorb.com/>`_ framework.

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

Use `RVM <https://rvm.io/>`_ or `rbenv <https://github.com/sstephenson/rbenv>`_
for environment management.

Install dependencies:

.. code-block:: bash

    $ cd YOUR_PROJECT_DIR/padrino/notejam/
    $ bundle install

------
Launch
------

Start built-in web server:

.. code-block:: bash

    $ cd YOUR_PROJECT_DIR/padrino/notejam/
    $ padrino start

Go to http://127.0.0.1:3000/ in your browser.


---------
Run tests
---------

Start functional and unit tests:

.. code-block:: bash

    $ cd YOUR_PROJECT_DIR/padrino/notejam/
    $ padrino rake spec


============
Contribution
============
Do you have ruby/padrino experience? Help the app to follow ruby and padrino best practices.

Please send your pull requests in the ``master`` branch.
Always prepend your commits with framework name:

.. code-block:: bash

    Padrino: Implemented sign in functionality

Read `contribution guide <https://github.com/komarserjio/notejam/blob/master/contribute.rst>`_ for details.
