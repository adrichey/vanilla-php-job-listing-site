FROM php:8.5.4-fpm

# Install dependencies
RUN apt-get update && apt-get upgrade -y
RUN apt-get install -y libicu-dev
RUN apt-get install -y pkg-config

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql intl