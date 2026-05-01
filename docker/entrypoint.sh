#!/bin/sh
set -e

# Always use docker env
cp .env.docker .env

# Clear any cached config first
php artisan config:clear

# Wait for MySQL to be ready
echo "Waiting for database..."
until php artisan migrate:status > /dev/null 2>&1; do
    echo "Database not ready, retrying in 3 seconds..."
    sleep 3
done

echo "Database is ready!"

# Fresh migrations and seeders
php artisan migrate:fresh --seed --force

# Cache config after migrations
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Start php-fpm
exec php-fpm
