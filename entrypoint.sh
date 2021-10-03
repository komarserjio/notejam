#!/bin/bash
python /app/notejam/manage.py syncdb --noinput
python /app/notejam/manage.py migrate --noinput
python /app/notejam/manage.py runserver 0.0.0.0:8080
