# https://hub.docker.com/_/php
FROM debian

RUN apt-get update && apt-get install -y apt-utils

RUN apt-get install -y nginx-light
RUN apt-get install -y postgresql
RUN apt-get install -y php7.3-fpm php7.3-pgsql

# https://stackoverflow.com/questions/44983961/installing-postgres-driver-in-php7-fpm-docker-container
#RUN apt-get install -y libpq-dev

### Copy static files

COPY index.php /var/www/
COPY init.sql /tmp/
COPY nginx/lnpon.conf /etc/nginx/sites-available/lnpon.conf
RUN ln -s /etc/nginx/sites-available/lnpon.conf /etc/nginx/sites-enabled/

### Configure Postgresql

USER postgres
RUN /etc/init.d/postgresql start &&\
    psql -d postgres -c "\i /tmp/init.sql"

### Starting services

CMD /etc/init.d/postgresql start &&\
    /etc/init.d/nginx start &&\
    cat /var/log/nginx/error.log

# utilisation de php 8
# wget -O /etc/apt/trusted.gpg.d/php.gpg https://packages.sury.org/php/apt.gpg
# echo "deb https://packages.sury.org/php/ buster main" |tee /etc/apt/sources.list.d/php.list
