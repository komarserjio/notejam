#!/bin/sh
touch app/database/notejam.db
yes | /usr/bin/php artisan migrate