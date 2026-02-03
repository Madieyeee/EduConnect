#!/bin/bash
set -e

echo "=== Starting EduConnect on Render ==="

# Wait for database to be ready
echo "Waiting for database..."
sleep 5

# Run migrations (not fresh, to preserve data)
echo "Running migrations..."
php artisan migrate --force || echo "Migration failed, continuing..."

# Create storage link if it doesn't exist
echo "Creating storage link..."
php artisan storage:link || echo "Storage link already exists"

# Cache configurations for production
echo "Caching configurations..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Start PHP-FPM in background
echo "Starting PHP-FPM..."
php-fpm -D

# Start Nginx in foreground
echo "Starting Nginx..."
nginx -g "daemon off;"
