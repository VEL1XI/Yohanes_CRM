#!/bin/bash

# Generate app key if not exists
if [ -z "$APP_KEY" ]; then
    php artisan key:generate --force
fi

# Run migrations
php artisan migrate --force

# Run seeders
php artisan db:seed --class=UserSeeder --force
php artisan db:seed --class=ServiceSeeder --force
php artisan db:seed --class=DummyDataSeeder --force

# Clear cache
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Start Apache
apache2-foreground