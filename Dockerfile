FROM php:8.2-fpm

# 1. Install system dependencies
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev zip unzip nginx

# 2. Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# 3. Install Node.js (needed for Vite/Inertia build)
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - && apt-get install -y nodejs

# 4. Set working directory
WORKDIR /var/www
COPY . .

# 5. Install Composer & Dependencies
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev

# 6. Build Frontend
RUN npm install
RUN npm run build

# 7. Permissions
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

EXPOSE 80

# 8. Start script (Migrates database and starts server)
CMD php artisan migrate --force && php artisan serve --host 0.0.0.0 --port 80