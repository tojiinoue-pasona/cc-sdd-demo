#!/bin/sh
set -e

[ -f .env ] || cp .env.example .env
php artisan key:generate --no-interaction --force
touch database/database.sqlite
php artisan migrate --force
php artisan db:seed --force

exec php artisan serve --host=0.0.0.0 --port=8000
