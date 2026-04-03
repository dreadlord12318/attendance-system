FROM php:8.2-fpm

# 1. Install minimum production dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev libonig-dev libxml2-dev zip unzip nginx

# 2. Install PHP extensions for Database
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# 3. Set working directory and copy files
WORKDIR /var/www
COPY . .

# 4. Permissions
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

EXPOSE 80

# 5. Start script
CMD php artisan migrate --force && php artisan serve --host 0.0.0.0 --port 80