# Step 1: Build the Vue assets using Node
FROM node:20 as build-stage
WORKDIR /app
COPY . .
RUN npm install
RUN npm run build

# Step 2: Set up the PHP environment
FROM php:8.2-fpm
WORKDIR /var/www

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git libpng-dev libonig-dev libxml2-dev zip unzip nginx

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Copy project files and the built assets from Node stage
COPY --from=build-stage /app /var/www

# Install Composer dependencies
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

# Setup Nginx and Permissions
RUN chown -R www-data:www-data /var/www/storage /var/www/cache
EXPOSE 80

# Simple start script
CMD php artisan migrate --force && php artisan serve --host 0.0.0.0 --port 80