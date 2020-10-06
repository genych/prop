FROM php:8.0-rc-alpine

RUN cp /usr/local/etc/php/php.ini-production /usr/local/etc/php/php.ini
RUN docker-php-ext-install pdo pdo_mysql
