# Step 1: Use a PHP image that also has Node installed
FROM php:8.2-fpm as build-stage

# Install system dependencies and Node.js
RUN apt-get update && apt-get install -y \
    git libpng-dev libonig-dev libxml2-dev zip unzip curl
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - && apt-get install -y nodejs

WORKDIR /app
COPY . .

# Install PHP dependencies first
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev

# Now build the frontend (PHP is now available for Wayfinder!)
RUN npm install
RUN npm run build

# Step 2: Final Production Image
FROM php:8.2-fpm
WORKDIR /var/www

# Install production dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev libonig-dev libxml2-dev zip unzip nginx

RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Copy everything from build stage
COPY --from=build-stage /app /var/www

# Fix permissions
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

EXPOSE 80

# Start script
CMD php artisan migrate --force && php artisan serve --host 0.0.0.0 --port 80