#!/usr/bin/env bash
set -e

php artisan migrate --force

php artisan storage:link || true

php artisan optimize

php -S 0.0.0.0:$PORT -t public
