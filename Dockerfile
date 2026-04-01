FROM php:8.3-cli AS php_builder

RUN apt-get update && apt-get install -y --no-install-recommends \
    git \
    unzip \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libzip-dev \
    libicu-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j"$(nproc)" gd zip pdo_mysql bcmath intl \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY composer.json composer.lock ./
RUN composer install --no-dev --prefer-dist --no-interaction --no-scripts --optimize-autoloader

COPY . .
RUN composer dump-autoload --optimize --no-dev

FROM node:20-alpine AS node_builder

WORKDIR /app

COPY package.json package-lock.json* ./
COPY vite.config.js ./
COPY tailwind.config.js* ./
COPY postcss.config.js* ./
RUN if [ -f package-lock.json ]; then npm ci; else npm install; fi

COPY resources ./resources
COPY public ./public
RUN npm run build

FROM php:8.3-cli

RUN apt-get update && apt-get install -y --no-install-recommends \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libzip-dev \
    libicu-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j"$(nproc)" gd zip pdo_mysql bcmath intl \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /app

COPY . .
COPY --from=php_builder /app/vendor ./vendor
COPY --from=node_builder /app/public/build ./public/build

# Create necessary directories with proper permissions
RUN mkdir -p storage/framework/cache storage/framework/sessions storage/framework/views bootstrap/cache \
    && mkdir -p storage/app/public \
    && chmod -R 755 storage bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache

# Setup Laravel application
RUN php artisan storage:link --force 2>/dev/null || true && \
    php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache

EXPOSE 8080

# Use init script for graceful startup
COPY <<'EOF' /usr/local/bin/start-app
#!/bin/sh
set -e

# Wait for database to be ready (optional, depends on Railway DB service)
echo "Starting OEK Application..."

# Run application
exec php artisan serve --host=0.0.0.0 --port=${PORT:-8080}
EOF

RUN chmod +x /usr/local/bin/start-app

CMD ["/usr/local/bin/start-app"]
