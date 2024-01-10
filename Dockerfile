# Use an official PHP runtime as a parent image
FROM php:8.1-fpm

# Set working directory
WORKDIR /var/www

# Install dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl \
    libonig-dev \
    libzip-dev \
    supervisor

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install extensions
RUN pecl install redis && docker-php-ext-enable redis
RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install Node.js
RUN curl -sL https://deb.nodesource.com/setup_20.x | bash - && apt-get install -y nodejs

# Copy existing application directory contents
COPY . /var/www

# Add user for laravel application
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

# Supervisor configurations
COPY ./docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Copy existing application directory permissions
# COPY --chown=www:www . /var/www
# Change owner of the copied directory
RUN chown -R www:www /var/www

# Change current user to www
USER www

# Install node dependencies
RUN npm install

# Build node dependencies
RUN npm run build

# Install composer dependecies
RUN composer install --no-interaction

EXPOSE 9000
CMD ["php-fpm"]
