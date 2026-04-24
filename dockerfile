FROM php:8.2-cli

WORKDIR /app

# Instalar dependencias
RUN apt-get update && apt-get install -y \
    unzip git curl libzip-dev zip \
    && docker-php-ext-install zip pdo pdo_mysql bcmath

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copiar proyecto
COPY . .

# Instalar dependencias Laravel
RUN composer install

# Exponer puerto
EXPOSE 8000

CMD php artisan serve --host=0.0.0.0 --port=8000