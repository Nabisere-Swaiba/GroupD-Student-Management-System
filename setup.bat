@echo off
REM Run this from the root of the Laravel project AFTER copying these files over a fresh Laravel install.
call composer require spatie/laravel-permission
call php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
if not exist .env copy .env.example .env
call php artisan key:generate --ansi
call php artisan migrate:fresh --seed
echo.
echo Done. Start the app with:  php artisan serve
echo Admin login: admin@campusdesk.test / password
