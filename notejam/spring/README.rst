***************
Notejam: Spring
***************

Notejam application implemented using `Spring <http://projects.spring.io/spring-framework/>`_ framework.

Spring version: 4.2.3

The full stack is:

- `Spring Boot <http://projects.spring.io/spring-boot/>`_ (Spring configuration)
- `Thymeleaf <http://www.thymeleaf.org/>`_ (View)
- `Spring Security <http://projects.spring.io/spring-security/>`_ (Security framework)
- `Spring`_ (DI and MVC framework)
- `Spring Data <http://projects.spring.io/spring-data/>`_ (Persistence abstraction)
- `JPA <http://www.oracle.com/technetwork/java/javaee/tech/persistence-jsp-140049.html>`_ (Persistence API)
- `Hibernate <http://hibernate.org/orm/>`_ (JPA implementation)

The application is maintained by `@malkusch <https://github.com/malkusch>`_.

==========================
Installation and launching
==========================

-----
Clone
-----

Clone the repo:

.. code-block:: bash

    $ git clone https://github.com/komarserjio/notejam YOUR_PROJECT_DIR/

-------
Install
-------

Install a `JDK <http://openjdk.java.net/>`_ and `Maven <https://maven.apache.org/>`_.

-------------
Configuration
-------------

The application has a password recovery process which involves sending an email.
If you want to enable that, you have to create a local application.properties file
and set there the property spring.mail.host to your SMTP server (e.g. spring.mail.host = smtp.example.net).

.. code-block:: bash

    $ cd YOUR_PROJECT_DIR/spring/
    $ vi application.properties

See `MailProperties <http://docs.spring.io/spring-boot/docs/current/api/index.html?org/springframework/boot/autoconfigure/mail/MailProperties.html>`_
for more mail properties.

------
Launch
------

Compile and launch the application:

.. code-block:: bash

    $ cd YOUR_PROJECT_DIR/spring/
    $ mvn spring-boot:run

Go to http://localhost:8080/ in your browser.

~~~~~~~~~~~~
Localization
~~~~~~~~~~~~

This application comes with support for the languages German and English. The locale is
determined by the Accept-Language request header. If the header is not present the
content will be served with the default locale of the JVM. The application will not
start if the default locale is non of the supported languages.

---------
Run tests
---------

Run functional and unit tests:

.. code-block:: bash

    $ cd YOUR_PROJECT_DIR/spring/
    $ mvn test

============
Contribution
============

Do you have Java/Spring experience? Help the application to follow Java and Spring best practices.

Please send your pull requests in the ``master`` branch.
Always prepend your commits with framework name:

.. code-block:: bash

    Spring: Implement sign in functionality

Read `contribution guide <https://github.com/komarserjio/notejam/blob/master/contribute.rst>`_ for details.
