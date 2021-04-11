FROM php:fpm

RUN apt-get update && apt-get upgrade -y
RUN apt-get install -y libpq-dev

# Install Postgres PDO drivers
RUN docker-php-ext-install pdo_mysql pdo_pgsql
