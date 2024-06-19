FROM php:8.1-fpm-alpine

ENV PHP_USER=shab
ENV PHP_GROUP=shab

RUN apk add --no-cache \
    autoconf \
    g++ \
    make \
    openssl-dev

RUN pecl install mongodb \
    && docker-php-ext-enable mongodb

RUN apk del --no-cache autoconf g++ make

RUN apk add --no-cache --virtual imagemagick-dev libxslt-dev icu-dev libzip-dev libpng-dev libjpeg-turbo-dev freetype-dev
RUN apk add --no-cache imagemagick libxslt icu-libs libzip libpng libjpeg-turbo freetype

RUN docker-php-ext-configure gd --enable-gd --with-freetype --with-jpeg
RUN docker-php-ext-install gd zip intl xsl bcmath
RUN docker-php-ext-enable  gd zip intl xsl bcmath
RUN docker-php-ext-install mysqli pdo pdo_mysql
RUN docker-php-ext-configure pcntl --enable-pcntl \
    && docker-php-ext-install pcntl;

RUN apk add --no-cache pcre-dev $PHPIZE_DEPS \
    && pecl install redis \
    && docker-php-ext-enable redis.so

    RUN adduser -g ${PHP_GROUP} -s /bin/sh -D ${PHP_USER}  

RUN sed -i "s/user = www-data/user = ${PHP_USER}/g" /usr/local/etc/php-fpm.d/www.conf
RUN sed -i "s/group = www-data/group = ${PHP_GROUP}/g" /usr/local/etc/php-fpm.d/www.conf
RUN echo 'memory_limit = 2048M' >> /usr/local/etc/php/conf.d/docker-fpm.ini;

RUN apk add --no-cache git
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php -r "if (hash_file('sha384', 'composer-setup.php') === 'dac665fdc30fdd8ec78b38b9800061b4150413ff2e3b6f88543c636f7cd84f6db9189d43a81e5503cda447da73c7e5b6') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"
RUN mv composer.phar /usr/local/bin/composer

RUN mkdir -p /var/www/html
