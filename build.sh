#!/usr/bin/env bash
# exit on error
set -o errexit

echo "Starting build process..."

# Install PHP dependencies with Composer
echo "Installing PHP dependencies..."
composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

# Generate application key if it does not exist
echo "Generating application key..."
php artisan key:generate --force --no-interaction

# Clear and cache configurations for production
echo "Caching configurations..."
php artisan config:clear
php artisan config:cache
php artisan route:clear
php artisan route:cache
php artisan view:clear
php artisan view:cache

echo "Build completed successfully!"
