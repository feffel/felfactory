FROM php:7.3.4-cli

RUN apt-get update \
    && apt-get -y install \
        git \
        unzip \
        wget

RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer

WORKDIR '/app'
