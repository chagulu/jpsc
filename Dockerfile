# Base image
FROM php:8.2-fpm

# Arguments for composer
ARG COMPOSER_ALLOW_SUPERUSER=1

# Set working directory
WORKDIR /var/www/html

# Install system dependencies + PHP extensions (pdo_mysql, mbstring, zip, bcmath, gd)
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libzip-dev \
    zip \
    libonig-dev \
    nodejs \
    npm \
    vim \
    lsof \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libwebp-dev \
    libxpm-dev \
    && docker-php-ext-configure gd \
        --with-freetype \
        --with-jpeg \
        --with-webp \
        --with-xpm \
    && docker-php-ext-install pdo_mysql mbstring zip bcmath gd \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# Copy existing application files
COPY ./src/myapp /var/www/html

# Install PHP dependencies
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Install Node dependencies and build assets
RUN npm install
RUN npm run build

# Expose port 8000 for Laravel
EXPOSE 8000

# Start Laravel server when container starts
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
