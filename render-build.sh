#!/usr/bin/env bash
set -e

# PHP deps (prod)
composer install --no-dev --prefer-dist --optimize-autoloader

# Frontend build
npm ci
npm run build

php artisan config:clear || true
php artisan route:clear  || true
php artisan view:clear   || true

php artisan config:cache
php artisan route:cache
php artisan view:cache
