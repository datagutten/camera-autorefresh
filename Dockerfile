FROM php:8.3-apache
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

RUN apt-get update && apt-get install -y libzip-dev
RUN docker-php-ext-install -j$(nproc) zip

WORKDIR /var/www/html

COPY *.php .
COPY src src
COPY composer.json .
RUN composer update
RUN mkdir images
RUN chown www-data images

EXPOSE 80