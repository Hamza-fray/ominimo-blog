#!/bin/bash
sudo chown -R $USER:$USER storage bootstrap/cache
chmod -R 775 storage bootstrap/cache
php artisan view:clear
php artisan config:clear
php artisan serve
