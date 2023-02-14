FROM php:7.4-fpm-alpine

ARG DOCKER_USER
ARG DOCKER_USER_GROUP_ID
ARG DOCKER_USER_ID
ARG DATABASE_URL
ENV SONAR_SCANNER_VERSION=4.6.2.2472

RUN apk --update --no-cache add git bash openssh shadow
RUN docker-php-ext-install pdo_mysql

RUN apk add --no-cache $PHPIZE_DEPS \
    && pecl install xdebug-3.0.0 \
    && docker-php-ext-enable xdebug \
    && echo "xdebug.remote_enable=on" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_connect_back = 1" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.discover_client_host=on" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.mode=debug, develop" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.start_with_request=yes" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.log=/var/log/nginx/xdebug.log" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "upload_max_filesize=10M" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "post_max_size=110M" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "upload_max_filesize=10M" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "post_max_size=110M" >> /usr/local/etc/php/conf.d/xdebug.ini

RUN addgroup -g $DOCKER_USER_GROUP_ID $DOCKER_USER \
    && adduser -u $DOCKER_USER_ID -G $DOCKER_USER -s /bin/sh -D $DOCKER_USER

RUN mkdir ~/.ssh/
WORKDIR /var/www/backend
ADD . .
RUN chmod -R 777 ./public
ENV DATABASE_URL=${DATABASE_URL}
COPY --from=composer /usr/bin/composer /usr/bin/composer
RUN pecl install -o -f redis && rm -rf /tmp/pear &&  docker-php-ext-enable redis
RUN composer update && composer install
CMD php-fpm

EXPOSE 9000
