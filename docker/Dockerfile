FROM php:8.3-cli

RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libcurl4-openssl-dev \
    libssl-dev \
    zip unzip curl git npm nodejs \
    && docker-php-ext-install pdo pdo_mysql mbstring zip exif pcntl bcmath \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 storage bootstrap/cache

RUN cp .env.example .env \
    && grep -q '^APP_KEY=' .env || echo 'APP_KEY=' >> .env

RUN composer install --no-interaction --prefer-dist --optimize-autoloader

RUN php artisan key:generate

RUN php artisan config:cache \
    && php artisan package:discover

EXPOSE 8000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
