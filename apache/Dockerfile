FROM    php:7.2-apache

ENV     APP_DIR=/usr/src/app/
ENV     APP_DIR_DATA=/usr/src/app/data/
ENV     APP_USER=app

RUN     docker-php-ext-install pdo pdo_mysql \
        && a2enmod rewrite \
        && service apache2 restart \
        && mkdir -p ${APP_DIR}

RUN     useradd -M -s /bin/bash ${APP_USER} \
        && chown ${APP_USER}. ${APP_DIR} -R \
        && chown 33.33 ${APP_DIR_DATA} -R

ADD     ./app.default.conf /etc/apache2/sites-enabled/000-default.conf

EXPOSE  80

WORKDIR /usr/src/app/