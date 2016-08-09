FROM php:5.6-apache

RUN apt-get update && apt-get install -y \
        libicu-dev \
        libpq-dev \
        libsqlite3-dev \
        git \
        unzip \
    && docker-php-ext-install \
        intl \
        pdo_sqlite \
        pdo_mysql \
    && a2enmod rewrite \
    && rm -rf /var/lib/apt/lists/*

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html

COPY . /var/www/html

RUN composer install --no-interaction --prefer-dist --no-dev

RUN chown -R www-data:www-data app/cache app/logs

EXPOSE 80
