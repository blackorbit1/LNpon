FROM php:fpm

RUN apt-get update && apt-get upgrade -y
RUN apt-get install -y libpq-dev

RUN mkdir /var/www/uploads && chown www-data:www-data /var/www/uploads

# Install Postgres PDO drivers
RUN docker-php-ext-install pdo_mysql pdo_pgsql
