ARG ENV
ARG TIMEZONE

FROM php:8.4.2-fpm

RUN apt-get update && apt-get install -y \
    apt-utils \
    git \
    libzip-dev \
    unzip \
    curl \
 && docker-php-ext-install zip

ARG ENV
RUN if [ "$ENV" = "dev" ]; then \
        pecl install xdebug && \
        docker-php-ext-enable xdebug ; \
    fi

COPY config/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini
COPY config/docker-php-memlimit.ini /usr/local/etc/php/conf.d/docker-php-memlimit.ini

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

ARG TIMEZONE
RUN ln -snf /usr/share/zoneinfo/$TIMEZONE /etc/localtime && echo $TIMEZONE > /etc/timezone

WORKDIR /var/www/app
