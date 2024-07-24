FROM php:8.3-fpm
RUN apt-get update && \
 apt-get install -y \
 zlib1g-dev \
 g++ \
 git \
 libicu-dev \
 zip \
 libzip-dev \
 unzip && \
 docker-php-ext-install intl opcache pdo pdo_mysql zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN useradd -G www-data -u 1000 -d /home/orders-api orders-api
RUN mkdir -p /home/orders-api/ && \
    chown -R orders-api:orders-api /home/orders-api

WORKDIR /var/www/orders-api

USER orders-api