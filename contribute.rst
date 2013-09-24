******************
Contribution guide
******************

=========================
Pull requests and commits
=========================

Always prepend commit message with framework name.

**Good** commit messages:

.. code-block::

    Django: Implemented signout functionality

.. code-block::

    Symfony: Fixed broken pad tests

**Bad** commit messages:

.. code-block::

    Implemented signout functionality in django

.. code-block::

    Fixed broken symfony pad tests
    

If you contribute into on of the existing application please 
send your pull requests in the specific branch
(e.g. ``django`` branch for Django framework, ``rubyonrails`` for Ruby on Rails)

If you develop new application submit your code in the ``master`` branch.

==========
Code style
==========

Please follow code style guidelines and best practices for your programming language and framework.
Specify guidelines in a README file in a code style section.


========================
Application requirements
========================

Notejam is web application that allows user to sign up/in/out and create/view/edit/delete notes. 
Notes are grouped by pads.

Live demo at http://notejamapp.com.

---------------------
Pages to be implement
---------------------

All layouts are sliced and located in the `html` folder.

**User pages**

* ``GET /signup/`` - Show Sign Up form
* ``POST /signup/`` - Sign Up
* ``GET /signin/`` - Show Sign In form
* ``POST /signin/`` - Sign In
* ``GET /signout/`` - Sign out
* ``GET /forgot-password/`` - Show Forgot password form
* ``POST /forgot-password/`` - Forgot Password request
* ``GET /settings/`` - Show user settings form
* ``POST /settings/`` - Change user settings


**Note pages**


* ``GET /notes/create/`` - Show Create note form
* ``POST /notes/create/`` - Create note
* ``GET /notes/<note_id>/`` - View note
* ``GET /notes/<note_id>/edit/`` - Show Edit note form
* ``POST /notes/<note_id>/edit/`` - Edit note
* ``GET /notes/<note_id>/delete/`` - Show confirmation delete page
* ``POST /notes/<note_id>/delete/`` - Delete note


**Pad pages**


* ``GET /pads/create/`` - Show Create note form
* ``POST /pads/create/`` - Create note
* ``GET /pads/<pad_id>/`` - View pad notes
* ``GET /pads/<pad_id>/edit/`` - Show Edit pad form
* ``POST /pads/<pad_id>/edit/`` - Edit pad
* ``GET /pads/<pad_id>/delete/`` - Show confirmation delete page
* ``POST /pads/<pad_id>/delete/`` - Delete pad


----
I18N
----

Application should support internationalization.
All source texts are available in the language files. 
Feel free to convert to any format that suits your application.

----------
Unit tests
----------

Unit tests are very desirable.

**Recommended test cases**

Sign Up:

* user can successfully sign up
* user can't sign up if required fields are missing
* user can't sign up if email is invalid
* user can't sign up if email already exists
* user can't sign up if passwords do not match

Sign In:

* user can successfully sign in
* user can't sign in if required fields are missing
* user can't sign in if credentials are wrong

Notes:

* note can be successfully created
* note can't be created if required fields are missing
* note can be edited by its owner
* note can't be edited if required fields are missing
* note can't be edited by not an owner
* note can be viewed by its owner
* note can't be viewed by not an owner
* note can be deleted by its owner
* note can't be deleted by not an owner

Pads:

* pad can be successfully created
* pad can't be created if required fields are missing
* pad can be edited by its owner
* pad can't be edited if required fields are missing
* pad can't be edited by not an owner
* pad can be viewed by its owner
* pad can't be viewed by not an owner
* pad can be deleted by its owner
* pad can't be deleted by not an owner
