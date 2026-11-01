#!/usr/bin/env bash
# Run this from the root of the Laravel project AFTER copying these files over a fresh Laravel install.
set -e
composer require spatie/laravel-permission
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
[ -f .env ] || cp .env.example .env
php artisan key:generate --ansi
php artisan migrate:fresh --seed
echo ""
echo "Done. Start the app with:  php artisan serve"
echo "Admin login: admin@campusdesk.test / password"
