#!/bin/bash
python /app/django/notejam/manage.py syncdb --noinput
python /app/django/notejam/manage.py migrate --noinput
python /app/django/notejam/manage.py runserver 0.0.0.0:8080
