#!/usr/bin/env bash
set -o errexit

# Install dependencies
composer install --no-dev --optimize-autoloader

# Generate application key
php artisan key:generate --force

# Cache config
php artisan config:cache
php artisan route:cache

# Run migrations
php artisan migrate --force

# Seed database (optionnel)
php artisan db:seed --force

echo "Build completed successfully!"
