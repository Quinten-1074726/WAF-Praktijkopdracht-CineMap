FROM node:20-alpine AS assets
WORKDIR /app
COPY package*.json ./
RUN npm ci
COPY resources ./resources
COPY vite.config.js tailwind.config.js postcss.config.js ./
RUN npm run build

FROM composer:2 AS vendor
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install \
    --no-dev --no-interaction --prefer-dist --no-progress \
    --optimize-autoloader --no-scripts

FROM php:8.3-fpm-bullseye

RUN apt-get update && apt-get install -y \
    nginx supervisor curl zip unzip git libpng-dev libonig-dev libxml2-dev libpq-dev \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql opcache \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html

COPY . /var/www/html

COPY --from=vendor /app/vendor /var/www/html/vendor
COPY --from=assets /app/public/build /var/www/html/public/build

COPY docker/nginx.conf /etc/nginx/nginx.conf
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

COPY docker/entrypoint.sh /entrypoint.sh
RUN sed -i 's/\r$//' /entrypoint.sh && chmod +x /entrypoint.sh
ENTRYPOINT ["/entrypoint.sh"]

EXPOSE 80
