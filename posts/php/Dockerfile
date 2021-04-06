FROM php:fpm

RUN apt update & apt upgrade

# Install Postgres PDO
RUN docker-php-ext-install pdo pdo_mysql pdo_pgsql

#RUN apt-get install -y libpq-dev \
#    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
#    && docker-php-ext-install pdo pdo_pgsql pgsql
