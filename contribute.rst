******************
Contribution guide
******************

At first play with live demo at http://notejamapp.com.

=========================
Pull requests and commits
=========================

Always prepend your commit with framework name.
Examples of good commit messages:

``Django: Implemented signout functionality``
``Symfony: Fixed broken pad tests``

If you contribute into on of the existing application please 
please send your pull requests to specific branch
(e.g. ``django`` branch for Django framework, ``rubyonrails`` for Ruby on Rails)

If you develop new application submit your code code in the ``master`` branch.

==========
Code style
==========


========================
Application requirements
========================

Notejam is web application that allows user to sign up/in/out and create/view/edit/delete notes. 
Notes are grouped by pads.

---------------------
Pages to be implement
---------------------

**User pages**

* GET /signup/ - Show Sign Up form
* POST /signup/ - Sign Up
* GET /signin/ - Show Sign In form
* POST /signin/ - Sign In
* GET /signout/ - Sign out
* GET /forgot-password/ - Show Forgot password form
* POST /forgot-password/ - Forgot Password request
* GET /settings/ - Show user settings form
* POST /settings/ - Change user settings


**Notes pages**


* GET /notes/create/ - Show Create note form
* POST /notes/create/ - Create note

-------
Layouts
-------

All layouts are located in the `html` folder.

----
I18N
----

Application should support internationalization.
All source texts are available in the language files. 
Feel free to convert to any format that suits your framework.

----------
Unit tests
----------

Unit tests are very desirable.

**Recommended test cases**

Signup:

* successfull signup
* failed signup because required fields are missing
* failed signup because email is invalid
* failed signup because email exists
* failed signup because passwords do not match

Notes:

* successfull create note
