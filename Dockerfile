FROM php:8.4-fpm-alpine

# Instalar dependencias y extensiones de PHP
RUN apk add --no-cache \
    curl \
    curl-dev \
    zip \
    libzip-dev \
    unzip \
    git \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    libxml2-dev \
    oniguruma-dev \
    mysql-client \
    imagemagick \
    imagemagick-dev \
    autoconf \
    g++ \
    make \
    && docker-php-ext-install -j$(nproc) \
    pdo_mysql \
    mysqli \
    mbstring \
    xml \
    bcmath \
    curl \
    zip \
    pcntl \
    gd \
    opcache

 # Instalar Imagick para generación de QR en PNG
RUN pecl install imagick \
    && docker-php-ext-enable imagick

# Instalar Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copiar TODO el código de una vez
COPY . .

# Permisos y evitar el warning de Git (dubious ownership)
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache \
    && git config --global --add safe.directory /var/www/html

# Configurar PHP
RUN cp /usr/local/etc/php/php.ini-production /usr/local/etc/php/php.ini
RUN sed -i 's/memory_limit = .*/memory_limit = 512M/' /usr/local/etc/php/php.ini
RUN sed -i 's/upload_max_filesize = .*/upload_max_filesize = 100M/' /usr/local/etc/php/php.ini
RUN sed -i 's/post_max_size = .*/post_max_size = 100M/' /usr/local/etc/php/php.ini
RUN sed -i 's/max_execution_time = .*/max_execution_time = 300/' /usr/local/etc/php/php.ini

# Solución para el error tempnam() en PHP 8.4 + Alpine
RUN echo "sys_temp_dir = /tmp" > /usr/local/etc/php/conf.d/temp-dir.ini

EXPOSE 9000
CMD ["php-fpm"]