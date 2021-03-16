# https://hub.docker.com/_/php
FROM php

RUN apt-get update && apt-get install -y apt-utils
###### Configuration PHP

# https://stackoverflow.com/questions/44983961/installing-postgres-driver-in-php7-fpm-docker-container
RUN apt-get update && apt-get install -y libpq-dev
RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql
RUN docker-php-ext-install pdo pdo_pgsql

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


CMD /etc/init.d/postgresql start
