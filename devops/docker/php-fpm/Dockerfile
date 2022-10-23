FROM composer:2 as composer
FROM php:8.1-fpm-bullseye

RUN apt-get update && \
    apt-get install -y --no-install-recommends \
      libssl-dev \
      zlib1g-dev \
      curl \
      git \
      unzip \
      netcat \
      libxml2-dev \
      libpq-dev \
      libzip-dev \
      yarnpkg && \
    pecl install apcu xdebug && \
    pecl clear-cache && \
    docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql && \
    docker-php-ext-install -j$(nproc) zip opcache intl pdo_pgsql pgsql && \
    docker-php-ext-enable apcu xdebug && \
    apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*



COPY --from=composer /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER=1

WORKDIR /var/www/html

EXPOSE 9091

CMD ["/usr/local/bin/php", "-S", "0.0.0.0:9091", "-t", "./public"]