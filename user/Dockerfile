# https://hub.docker.com/_/php
FROM debian

RUN apt-get update && apt-get install -y apt-utils
###### Configuration PHP

RUN apt-get install -y nginx php7.3-fpm

# https://stackoverflow.com/questions/44983961/installing-postgres-driver-in-php7-fpm-docker-container
RUN apt-get install -y libpq-dev

RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql
RUN docker-php-ext-install pdo pdo_pgsql

COPY nginx/lnpon.conf /etc/nginx/site-available/lnpon.conf
COPY nginx/gateway_headers.conf /etc/nginx/snippets/gateway_headers.conf

RUN ln -s /etc/nginx/site-available/lnpon.conf /etc/nginx/site-enabled/

# https://www.postgresql.org/download/linux/ubuntu/
RUN apt-get -y install postgresql

COPY index.php /var/www/
COPY init.sql /var/www/

###### Configuration Postgresql

USER postgres
RUN /etc/init.d/postgresql start &&\
    psql --command "CREATE USER \"www-data\" WITH PASSWORD 'www-data';" &&\
    createdb -O "www-data" user_db &&\
    psql -d user_db -c "\i /var/www/init.sql"

# docker run -t -d lnpon_users /bin/bash
CMD /etc/init.d/nginx start && /etc/init.d/postgresql start && bash

# utilisation de php 8
# wget -O /etc/apt/trusted.gpg.d/php.gpg https://packages.sury.org/php/apt.gpg
# echo "deb https://packages.sury.org/php/ buster main" |tee /etc/apt/sources.list.d/php.list
