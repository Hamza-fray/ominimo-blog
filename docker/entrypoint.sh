#!/bin/sh
set -e

# Wait for DB to be ready (extra safety on top of healthcheck)
echo "Waiting for database..."
sleep 3

# Copy .env if it doesn't exist
if [ ! -f .env ]; then
    cp .env.example .env
    php artisan key:generate
fi

# Run migrations and seeders
php artisan migrate --force
php artisan db:seed --force

# Clear and cache config
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Start php-fpm
exec php-fpm
