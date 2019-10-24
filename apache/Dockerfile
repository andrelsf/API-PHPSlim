FROM    php:7.2-apache

RUN     docker-php-ext-install pdo_mysql \
        && a2enmod rewrite \
        && mkdir -p /usr/src/app/

ADD     ./app.default.conf /etc/apache2/sites-enabled/000-default.conf

EXPOSE 80

WORKDIR /usr/src/app/