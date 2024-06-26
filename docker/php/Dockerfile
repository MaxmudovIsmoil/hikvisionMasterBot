# Image
FROM php:8.3-fpm

# Initialize
RUN apt-get update

# Git
RUN apt-get install -y git

# Curl
RUN apt-get install -y libcurl3-dev curl && docker-php-ext-install curl

# GD
RUN apt-get install -y libfreetype6-dev libjpeg62-turbo-dev libpng-dev
RUN docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/
RUN docker-php-ext-install gd

# BC Math
RUN docker-php-ext-install bcmath

# intl
RUN apt-get install -y zlib1g-dev libicu-dev g++ && \
    docker-php-ext-configure intl && \
    docker-php-ext-install intl

RUN apt-get install -y libzip-dev \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip

# MySQL
RUN docker-php-ext-install pdo_mysql

# Custom php.ini config
COPY php.ini /usr/local/etc/php/php.ini

# Composer installation
COPY --from=composer:2.7 /usr/bin/composer /usr/local/bin/composer

# Set Composer Config
RUN composer config -g process-timeout 3600 && \
    composer config -g repos.packagist composer https://packagist.org

# Clean up
RUN apt-get clean && \
    apt-get -y autoremove && \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*
