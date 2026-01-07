FROM php:8.2-fpm

COPY ./php.ini /usr/local/etc/php/conf.d/custom.ini

RUN apt-get update && apt-get install -y \
    zip \
    unzip \
    git \
    curl \
    libzip-dev \
    && docker-php-ext-install pdo pdo_mysql \
    && apt-get clean

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html