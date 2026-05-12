FROM php:8.4-cli

RUN apt-get update && apt-get install -y \
        sqlite3 libsqlite3-dev unzip git \
    && docker-php-ext-install pdo pdo_sqlite \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY composer.json composer.lock ./
RUN composer install --optimize-autoloader --no-scripts

COPY . .

RUN php artisan package:discover --ansi \
    && chmod -R 775 storage bootstrap/cache

EXPOSE 8080

ENTRYPOINT ["sh", "docker/entrypoint.sh"]
