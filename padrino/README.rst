*******************************
Notejam: Padrino implementation
*******************************

Notejam application implemented using Padrino framework.

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

Using rbenv or RVM is strongly advised.

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

Start unit/functional tests:

.. code-block:: bash

    $ cd YOUR_PROJECT_DIR/padrino/notejam/
    $ padrino rake spec

