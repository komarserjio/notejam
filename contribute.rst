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
Example: ...


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

Pads:

* successfull create pad
