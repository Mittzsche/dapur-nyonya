# Stage 1: Build stage
FROM composer:latest AS composer-build

WORKDIR /app

# Copy composer files first for better caching
COPY composer.json composer.lock ./

# Install dependencies
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist

# Copy application code
COPY . .

# Generate optimized autoloader
RUN composer dump-autoload --optimize --no-dev

# Stage 2: Production stage
FROM php:8.4-fpm-alpine

# Install system dependencies
RUN apk add --no-cache \
    nginx \
    supervisor \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    libzip-dev \
    oniguruma-dev \
    icu-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
        pdo_mysql \
        mbstring \
        exif \
        pcntl \
        bcmath \
        gd \
        zip \
        intl \
        opcache

# Configure PHP for production
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

# Copy custom PHP config
COPY docker/php.ini /usr/local/etc/php/conf.d/custom.ini

# Copy nginx config
COPY docker/nginx.conf /etc/nginx/http.d/default.conf

# Copy supervisor config
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

WORKDIR /var/www/html

# Copy application from build stage
COPY --from=composer-build /app/vendor ./vendor
COPY . .

# Set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache

# Create storage link directory structure
RUN mkdir -p /var/www/html/public/storage

# Expose port
EXPOSE 8080

# Health check
HEALTHCHECK --interval=30s --timeout=3s \
    CMD wget --no-verbose --tries=1 --spider http://localhost:8080/api/health || exit 1

# Start supervisor (manages nginx and php-fpm)
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
