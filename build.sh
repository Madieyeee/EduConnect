#!/usr/bin/env bash
set -o errexit

# Install dependencies
composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

# Cache config and routes and views for performance
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "Build completed successfully!"
