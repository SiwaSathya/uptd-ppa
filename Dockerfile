FROM php:8.2-fpm

# Set working directory
WORKDIR /var/www

# Install dependensi sistem, tools, dan Nginx (Ditambahkan libzip-dev)
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libpq-dev \
    libsodium-dev \
    libzip-dev \
    zip \
    unzip \
    nginx \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Konfigurasi dan install ekstensi PHP bawaan (Ditambahkan ekstensi zip)
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd pdo_pgsql opcache sodium zip

# Install ekstensi Redis via PECL
RUN pecl install redis && docker-php-ext-enable redis

# Ambil Composer versi terbaru
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Salin seluruh file project ke dalam container
COPY . /var/www

# Atur permissions folder agar Laravel bisa menulis logs/cache
RUN chown -R www-data:www-data /var/www \
    && chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Install dependensi Composer (production mode)
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN composer install --no-interaction --optimize-autoloader --no-dev

# Tulis konfigurasi Nginx langsung di sini agar praktis
RUN echo 'server { \n\
    listen 8080; \n\
    root /var/www/public; \n\
    index index.php index.html; \n\
    location / { \n\
    try_files $uri $uri/ /index.php?$query_string; \n\
    } \n\
    location ~ \\.php$ { \n\
    include fastcgi_params; \n\
    fastcgi_pass 127.0.0.1:9000; \n\
    fastcgi_index index.php; \n\
    fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name; \n\
    } \n\
    }' > /etc/nginx/sites-available/default

# Jalankan optimasi cache Laravel, ganti port Nginx sesuai dynamic port Railway, lalu start PHP-FPM & Nginx
CMD php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache \
    && sed -i "s/listen 8080;/listen ${PORT};/g" /etc/nginx/sites-available/default \
    && php-fpm -D \
    && nginx -g "daemon off;"