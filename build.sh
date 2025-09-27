#!/usr/bin/env bash
# exit on error
set -o errexit

# Installe les dépendances PHP avec Composer
composer install --no-dev --no-interaction --no-plugins --no-scripts --prefer-dist

# Génère la clé d'application (Render ne lira pas le .env)
php artisan key:generate --force

# Nettoie et met en cache les configurations pour la production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Lance les migrations de la base de données
php artisan migrate --force
