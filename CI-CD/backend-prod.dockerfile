FROM nexus-dockerhub.andersenlab.dev/php:8.0-fpm-alpine as builder-api
ARG DATABASE_URL
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

COPY --from=composer /usr/bin/composer /usr/bin/composer
WORKDIR /var/www/backend
ADD . .
RUN chmod -R 777 ./public
ENV DATABASE_URL=${DATABASE_URL}
RUN pecl install -o -f redis && rm -rf /tmp/pear &&  docker-php-ext-enable redis
RUN composer require symfony/console:^5.3 && composer install

FROM nginx:alpine
COPY --from=builder-api /var/www/backend /var/www/backend
COPY --from=builder-api /var/www/backend/tools/nginx/nginx.conf /etc/nginx/nginx.conf
COPY --from=builder-api /var/www/backend/tools/nginx/conf.d /etc/nginx/conf.d
COPY --from=builder-api /var/www/backend/tools/nginx/sites /etc/nginx/sites-available

ENTRYPOINT ["nginx", "-g", "daemon off;"]
