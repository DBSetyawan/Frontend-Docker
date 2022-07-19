FROM php:8.1.4-fpm-alpine3.14

LABEL maintainer='daniel'

# Install system dependencies
RUN apk update && apk add --no-cache \
    libpng-dev \
    oniguruma-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    curl

# Install system tools
RUN apk add git vim busybox-extras procps net-tools iputils

# Clear cache
RUN rm -rf /var/cache/apk/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd mysqli zip


# Install nodejs/npm
RUN apk add --update bash npm nodejs

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# EXPOSE 9000
# CMD ["php-fpm"]
USER $user
