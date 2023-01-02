ARG FRANKENPHP_VERSION="sha-4332bbe"
FROM composer:2 as composer
FROM dunglas/frankenphp:${FRANKENPHP_VERSION} as base

COPY --from=composer /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER=1

RUN apt-get update && apt-get install --no-install-recommends -y \
    unzip \
    yarnpkg \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

RUN install-php-extensions \
    opcache \
    pdo_pgsql \
    intl \
    zip

WORKDIR /app

# DEV stage
FROM base as dev

RUN curl https://xdebug.org/files/xdebug-3.2.0RC2.tgz --output /tmp/xdebug.tgz \
    && mkdir /tmp/xdebug \
    && tar -xzf /tmp/xdebug.tgz -C /tmp/xdebug --strip-components=1 \
    && cd /tmp/xdebug \
    && phpize \
    && ./configure --enable-xdebug \
    && make \
    && make install

COPY ./devops/docker/frankenphp/conf.d/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

# CD stage
FROM base as build

ENV APP_ENV=prod
ENV APP_DEBUG=0

# get the code
COPY --chown=www-data:www-data ./app /app

# build production
RUN make install-production

# production stage
FROM dunglas/frankenphp:${FRANKENPHP_VERSION} as production

ENV APP_ENV=prod
ENV APP_DEBUG=0

RUN install-php-extensions \
    opcache \
    pdo_pgsql \
    intl \
    zip

COPY --from=build /app/bin/console /app/bin/console
COPY --from=build /app/config /app/config
COPY --from=build /app/migrations /app/migrations
COPY --from=build /app/public/build /app/public/build
COPY --from=build /app/public/index.php /app/public/index.php
COPY --from=build /app/src /app/src
COPY --from=build /app/templates /app/templates
COPY --from=build /app/vendor /app/vendor

RUN mkdir -p /app/var/cache/prod /app/var/log/prod /app/                                                   var/database \
    && chown -R www-data:www-data /app/var/

USER www-data