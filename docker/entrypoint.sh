#!/bin/sh
set -e

# Use docker env
cp .env.docker .env

# Clear any cached config first
php artisan config:clear

# Fix storage permissions
chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
chmod -R 775 /var/www/storage /var/www/bootstrap/cache

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

# Restore local .env after docker setup
cp .env.docker .env
sed -i 's/DB_HOST=db/DB_HOST=127.0.0.1/' .env

# Start php-fpm
exec php-fpm
