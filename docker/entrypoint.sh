#!/bin/sh
set -e

# Use docker env
cp .env.docker .env

# Generate app key if not set
APP_KEY_VALUE=$(grep 'APP_KEY=' .env | cut -d '=' -f2)
if [ -z "$APP_KEY_VALUE" ]; then
    php artisan key:generate --force
fi

# Clear any cached config first
php artisan config:clear

# Fix storage permissions
chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Wait for MySQL to be ready
echo "Waiting for database..."
until php -r "new PDO('mysql:host=db;port=3306;dbname=ominimo_blog', 'root', 'root');" > /dev/null 2>&1; do
    echo "Database not ready, retrying in 3 seconds..."
    sleep 3
done

echo "Database is ready!"

# Fresh migrations and seeders
php artisan migrate:fresh --seed --force
# Build frontend assets
npm run build
# Cache config after migrations
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Restore local .env after docker setup
cp .env.docker .env
sed -i 's/DB_HOST=db/DB_HOST=127.0.0.1/' .env
# Start php-fpm
exec php-fpm
