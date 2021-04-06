FROM php:fpm

RUN apt-get update && apt-get upgrade -y

# Install Postgres PDO drivers
RUN docker-php-ext-install pdo pdo_mysql pdo_pgsql
