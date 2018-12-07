# Dockerized Node.js/Express implementation of Notejam by Sergey Komar
#
# VERSION: 0.0.1

FROM node:10.13.0

ENV NOTEJAM_PORT=3000

EXPOSE $NOTEJAM_PORT/tcp
USER node
WORKDIR /home/node/app/notejam

COPY --chown=node:node . /home/node/app

RUN npm install &&\
    curl -s https://raw.githubusercontent.com/vishnubob/wait-for-it/master/wait-for-it.sh > /home/node/app/notejam/wait-for-it.sh &&\
    chmod 0755 /home/node/app/notejam/wait-for-it.sh

CMD [ "/home/node/app/notejam/start-notejam.sh" ]
