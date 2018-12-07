Notejam App
===========

Builds an image that runs the [Node.js/Express implementation of Notejam by Sergey Komar](https://github.com/komarserjio/notejam/tree/master/express) n-Tier application framework.


Requirements
------------

This role requires geerlingguy.nodejs

Role Variables
--------------

Variables for this role include.
* `env`: The environment in which this app will run.


Dependencies
------------

This role requires the following additional roles in order to build:
- geerlingguy.nodejs

Example Playbook
----------------

Including an example of how to use your role (for instance, with variables passed in as parameters) is always nice for users too:

    - hosts: servers
      roles:
         - { role: notejam-app env: test }

License
-------

BSD


Author Information
------------------

Created by Graham Trummell
