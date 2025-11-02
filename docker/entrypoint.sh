#!/bin/sh
set -e

php -r "file_exists('.env') || copy('.env.example', '.env');" || true

php artisan key:generate --force || true

php artisan config:cache || true
php artisan route:cache  || true
php artisan view:cache   || true

php artisan storage:link || true

php artisan migrate --force || true

exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
