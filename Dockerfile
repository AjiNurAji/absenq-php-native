FROM php:8.4-apache

# Install necessary PHP extensions and other dependencies
RUN apt-get update && apt-get install -y \
  libpng-dev \
  libjpeg-dev \
  libfreetype6-dev \
  libonig-dev \
  libzip-dev \
  zip \
  unzip \
  git \
  && docker-php-ext-configure gd --with-freetype --with-jpeg \
  && docker-php-ext-install gd mbstring zip pdo pdo_mysql

# enable Apache mod_rewrite
RUN a2enmod rewrite

# install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN composer install

# Set working directory
WORKDIR /var/www/html