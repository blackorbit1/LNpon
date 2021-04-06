FROM php:fpm

RUN apt update && apt upgrade

# Install Postgres PDO drivers
RUN docker-php-ext-install pdo pdo_mysql pdo_pgsql
