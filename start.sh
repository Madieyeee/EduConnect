#!/bin/bash
set -e

echo "=== Starting EduConnect on Railway ==="

# Attendre que la base de données soit prête
echo "Waiting for database connection..."
sleep 15

# Nettoyer tous les caches pour assurer une configuration fraîche
echo "Clearing all caches to ensure fresh config..."
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

# Exécuter les migrations de la base de données
echo "Running database migrations..."
php artisan migrate --force

# Lier le stockage
echo "Linking storage..."
php artisan storage:link

# Mettre en cache les routes et les vues (sûr à l'exécution)
echo "Caching routes and views for performance..."
php artisan route:cache
php artisan view:cache

echo "Starting PHP-FPM..."
php-fpm -D

echo "Starting Nginx..."
# Nginx s'exécute au premier plan pour maintenir le conteneur en vie.
nginx -g "daemon off;"
