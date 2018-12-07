#!/bin/bash

# Determin if node_modules are present; if not run `npm install` to retrieve them.
if [[ ! -d ./node_modules ]]; then
    $(which npm) install
fi

# Determine if wait-for-it.sh is available, retrieve it if not.
if [[ ! -x ./wait-for-it.sh ]]; then
    curl -s https://raw.githubusercontent.com/vishnubob/wait-for-it/master/wait-for-it.sh > ./wait-for-it.sh
    chmod 0755 ./wait-for-it.sh
fi

# Execute wait-for-it.sh and post a return code.
./wait-for-it.sh "$MYSQL_HOST":"$MYSQL_TCP_PORT" -t 90

# Read the return code from wait-for-it.sh and launch NoteJam or exit.
if [[ $? -ne 0 ]]; then
    echo "Could not connect to MySQL.  Notejam failed!"
    exit 1
fi

DEBUG=* ./bin/www
