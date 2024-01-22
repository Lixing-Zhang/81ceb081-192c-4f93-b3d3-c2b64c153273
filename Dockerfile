FROM php:8.2

RUN apt update && apt upgrade -y

RUN apt install git zip -y

USER root

# INSTALL AND UPDATE COMPOSER
COPY --from=composer /usr/bin/composer /usr/bin/composer

RUN composer self-update

WORKDIR /var/app

COPY . .

RUN composer install --prefer-dist
