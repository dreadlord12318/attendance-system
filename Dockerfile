FROM php:8.4-fpm

# 1. Install system dependencies (Adding libpq-dev for PostgreSQL)
RUN apt-get update && apt-get install -y \
    libpng-dev libonig-dev libxml2-dev zip unzip nginx libpq-dev

# 2. Install PHP extensions (including pgsql)
RUN docker-php-ext-install pdo_pgsql pgsql mbstring exif pcntl bcmath gd

# 3. Set working directory and copy files
WORKDIR /var/www
COPY . .

# 4. Permissions
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

EXPOSE 80

# 5. Start script
CMD php artisan migrate --force && php artisan serve --host 0.0.0.0 --port 80