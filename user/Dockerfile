# https://hub.docker.com/_/php
FROM debian

RUN apt-get update && apt-get upgrade -y

RUN apt-get install -y nginx-light
RUN apt-get install -y postgresql
RUN apt-get install -y php7.3-fpm php7.3-pgsql

### Copy static files

COPY index.php /var/www/
COPY init.sql /tmp/
COPY nginx/lnpon.conf /etc/nginx/sites-available/lnpon.conf
RUN ln -s /etc/nginx/sites-available/lnpon.conf /etc/nginx/sites-enabled/

#RUN rm /var/log/nginx/error.log &&\
#    ln -s /dev/stdout /var/log/nginx/error.log

### Configure Postgresql

USER postgres
RUN /etc/init.d/postgresql start &&\
    psql -d postgres -c "\i /tmp/init.sql"

### Starting services

USER root
CMD /etc/init.d/nginx start &&\
    /etc/init.d/postgresql start

# utilisation de php 8
# wget -O /etc/apt/trusted.gpg.d/php.gpg https://packages.sury.org/php/apt.gpg
# echo "deb https://packages.sury.org/php/ buster main" |tee /etc/apt/sources.list.d/php.list
