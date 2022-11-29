FROM composer:2 as composer
FROM dunglas/frankenphp:latest as production

RUN install-php-extensions \
    opcache \
    pdo_pgsql \
    intl \
    zip

# DEV stage
FROM production as dev

COPY --from=composer /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER=1

RUN apt-get update && apt-get install -y \
    unzip \
    yarnpkg \
    && rm -rf /var/lib/apt/lists/*

RUN  curl https://xdebug.org/files/xdebug-3.2.0RC2.tgz --output /tmp/xdebug.tgz \
    && mkdir /tmp/xdebug \
    && tar -xzf /tmp/xdebug.tgz -C /tmp/xdebug --strip-components=1 \
    && cd /tmp/xdebug \
    && phpize \
    && ./configure --enable-xdebug \
    && make \
    && make install

COPY ./devops/docker/frankenphp/conf.d/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

# CD stage
FROM production as final

COPY . /app