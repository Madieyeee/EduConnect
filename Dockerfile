# Use PHP 8.1 FPM
FROM php:8.1-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libpq-dev \
    libzip-dev \
    nginx \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions required by Laravel
RUN docker-php-ext-install pdo_pgsql mbstring exif pcntl bcmath gd zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy all application files
COPY . .

# Debug and install dependencies
RUN echo "=== Debugging Composer ===" \
    && ls -la \
    && echo "=== Composer version ===" \
    && composer --version \
    && echo "=== PHP version ===" \
    && php --version \
    && echo "=== Installing dependencies ===" \
    && composer install --no-dev --optimize-autoloader --no-interaction --ignore-platform-reqs \
    && echo "=== Composer install completed ==="

# Set permissions
RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www/storage \
    && chmod -R 755 /var/www/bootstrap/cache

# Configure Nginx
RUN echo 'server {\n\
    listen 80;\n\
    root /var/www/public;\n\
    index index.php;\n\
    location / {\n\
        try_files $uri $uri/ /index.php?$query_string;\n\
    }\n\
    location ~ \.php$ {\n\
        fastcgi_pass 127.0.0.1:9000;\n\
        fastcgi_index index.php;\n\
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;\n\
        include fastcgi_params;\n\
    }\n\
}' > /etc/nginx/sites-available/default

# Create startup script
RUN echo '#!/bin/bash\n\
set -e\n\
echo "Starting EduConnect..."\n\
php artisan config:cache || echo "Config cache failed"\n\
php artisan route:cache || echo "Route cache failed"\n\
php artisan storage:link || echo "Storage link failed"\n\
echo "Running fresh migration with seeders..."\n\
php artisan migrate:fresh --seed --force || echo "Fresh migration failed"\n\
echo "Starting PHP-FPM..."\n\
php-fpm -D\n\
echo "Starting Nginx..."\n\
nginx -g "daemon off;"' > /start.sh

RUN chmod +x /start.sh

EXPOSE 80

CMD ["/start.sh"]
