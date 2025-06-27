FROM php:8.3-fpm-alpine3.20

COPY . /var/www/html

RUN chmod -R 755 /var/www/html
RUN chown -R www-data:www-data /var/www/html

RUN apk update
RUN docker-php-source extract \
    && docker-php-ext-install pdo pdo_mysql \
    && docker-php-source delete
