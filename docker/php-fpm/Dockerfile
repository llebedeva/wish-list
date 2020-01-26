FROM php:7.3.8-fpm-alpine3.9

RUN docker-php-ext-install \
    pdo_mysql

ENV PHPIZE_DEPS \
    autoconf \
    g++ \
    make

RUN set -xe && \
    apk add --no-cache --virtual .build-deps $PHPIZE_DEPS && \
    pecl install xdebug && \
    docker-php-ext-enable xdebug && \
    apk del -f .build-deps
