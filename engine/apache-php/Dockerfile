FROM php:7.4.1-apache

MAINTAINER Jean Mariette <jmariette@rampar.com>

ENV COMPOSER_HOME="/tmp" \
COMPOSER_ALLOW_SUPERUSER=1

EXPOSE 80
WORKDIR /app

RUN apt-get update -qy && \
    apt-get install -y --no-install-recommends \
    git=1:2.20.1\* \
    libicu-dev=63.1\* \
    unzip=6.0\* \
    bzip2=1.0.6\* \
    libpng-dev=1.6.36\* \
    libbz2-dev=1.0.6\* \
    libzip-dev=1.5.1\* \
    nodejs=10.21.0\* \
    npm=5.8.0\* \
    libgmp-dev=2:6.1\* \
    zip=3.0\* \
    libpq-dev=11.7\* && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/*

SHELL ["/bin/bash", "-o", "pipefail", "-c"]
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN rm -rf /tmp/* /var/tmp/*

RUN npm install -g yarn@1.19.1


RUN docker-php-ext-install pdo_mysql  zip  bz2  gd  gmp intl pdo_pgsql
COPY php.ini /usr/local/etc/php/conf.d/app.ini

RUN a2enmod rewrite

COPY vhost.conf /etc/apache2/sites-available/000-default.conf
COPY apache.conf /etc/apache2/conf-available/z-app.conf


RUN a2enconf z-app

CMD ["/usr/sbin/apache2ctl", "-D", "FOREGROUND"]
