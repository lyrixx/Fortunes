FROM php:7.1-fpm
MAINTAINER "Grégoire Pineau <lyrixx@lyrixx.info>"

RUN apt-get update && apt-get install -y libpq-dev curl git

RUN /usr/local/bin/docker-php-ext-install pdo_pgsql
RUN /usr/local/bin/docker-php-ext-install zip
RUN /usr/local/bin/docker-php-ext-install opcache
RUN /usr/local/bin/docker-php-ext-install mbstring
RUN pecl install apcu-5.1.7

COPY php.ini /usr/local/etc/php/conf.d/php.ini

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN mkdir -p /var/www/html/var/cache
RUN mkdir -p /var/www/html/var/logs
RUN mkdir -p /var/www/html/var/sessions
RUN chown www-data:www-data /var/www/html/var/cache
RUN chown www-data:www-data /var/www/html/var/logs
RUN chown www-data:www-data /var/www/html/var/sessions
