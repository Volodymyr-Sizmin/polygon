# Dockerfile for apidoc
FROM node:16-alpine

ENV NPM_CONFIG_PREFIX=/home/node/.npm-global

ENV PATH=$PATH:$NPM_CONFIG_PREFIX/bin

USER node

RUN mkdir -p /home/node/apidoc

WORKDIR /home/node/apidoc

RUN npm install --only=prod -g apidoc

CMD apidoc -i /project-root/ -o /project-root/apidocs