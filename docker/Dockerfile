FROM php:7.2-fpm

RUN apt-get update && \
    apt-get install -y git zip \
    && docker-php-ext-install session pdo pdo_mysql

RUN curl --silent --show-error https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer