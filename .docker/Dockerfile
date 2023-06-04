# syntax=docker/dockerfile:experimental
# First stage : Install Composer packages
FROM composer:2.5 as composer-build
RUN mkdir -p ~/.ssh/ && ssh-keyscan github.com >> ~/.ssh/known_hosts
COPY --chown=www-data:www-data ./composer.json /app/composer.json
RUN composer update

# Second stage : PHP extensions
FROM php:8.2-cli-alpine as php-extensions-build
RUN apk update && \
    apk add --no-cache \
        zip \
        unzip \
        openssh \
        libzip-dev

RUN docker-php-ext-install -j$(nproc) zip bcmath pcntl opcache

# Final build, "app", the base for others
FROM php:8.2-cli-alpine as app
RUN echo http://dl-2.alpinelinux.org/alpine/edge/community/ >> /etc/apk/repositories
RUN apk --no-cache add shadow && usermod -u 1000 www-data
RUN apk update && \
    apk add --no-cache \
    docker \
    openssh

COPY --from=php-extensions-build /usr/local/lib/php/extensions/no-debug-non-zts-20220829/ /usr/local/lib/php/extensions/no-debug-non-zts-20220829/
COPY --from=php-extensions-build /usr/lib/ /usr/local/lib
RUN docker-php-ext-enable zip bcmath pcntl
COPY --chown=www-data:www-data --from=composer-build /app /app
WORKDIR /app

ENTRYPOINT [ "/app/drzl" ]

# Various stages for release/dev/etc...
# Release stage, what will be deployed on our servers
FROM app as release
COPY .docker/opcache.ini /usr/local/etc/.docker/conf.d/opcache.ini
RUN docker-php-ext-enable opcache

# Default docker build target will be 'app'
FROM app