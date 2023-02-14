FROM php:8.0-fpm-alpine

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

#RUN addgroup -g 1000 api \
#    && adduser -u 1000 -G api -s /bin/sh -D api
#USER api

#RUN mkdir ~/.ssh/

COPY --from=composer /usr/bin/composer /usr/bin/composer
WORKDIR /var/www/backend

CMD composer install ; php-fpm

EXPOSE 9000
