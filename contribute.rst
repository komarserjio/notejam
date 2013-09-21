******************
Contribution guide
******************

=========================
Pull requests and commits
=========================

Always prepend commit message with framework name.

Examples of **good** commit messages:

``Django: Implemented signout functionality``
``Symfony: Fixed broken pad tests``

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

* successfull sign up
* failed sign up because required fields are missing
* failed sign up because email is invalid
* failed sign up because email exists
* failed sign up because passwords do not match

Sign In:

* successfull sign in
* failed sign in becaure required fields are missing
* failed sign in becaure credentials are wrong

Notes:

* successfull create note
* failed note creation because required fields are missing

Pads:

* successfull create pad
* failed pad creation because required fields are missing
