FROM php:8.0-fpm-alpine

ENV DATABASE_URL="mysql://api-user:api-user-password@10.10.14.22:3303/test"
RUN apk --update --no-cache add git bash openssh shadow
RUN docker-php-ext-install pdo_mysql

COPY --from=composer /usr/bin/composer /usr/bin/composer
COPY . /var/www/backend
RUN ls -lsa /var/www/backend/migrations
WORKDIR /var/www/backend
#RUN whoami && chown api /var/www/backend

RUN composer require symfony/console:^5.3
RUN php bin/console doctrine:schema:update --dump-sql
RUN php bin/console doctrine:schema:validate
RUN composer install
RUN composer require --dev symfony/test-pack
CMD ["php", "bin/phpunit", "tests/Controller"]
#RUN php bin/phpunit
#RUN php-fpm
