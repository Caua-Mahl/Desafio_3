FROM php:7.4-apache

WORKDIR /var/www/html
COPY . /var/www/html

RUN apt-get update

# Drivers PDO E PGSQL
RUN apt-get install -y libpq-dev \
  && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
  && docker-php-ext-install pdo pdo_pgsql pgsql

# Extensão CURL
RUN apt-get install -y \
  libcurl4-openssl-dev \
  && docker-php-ext-install -j$(nproc) curl