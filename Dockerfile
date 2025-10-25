FROM php:8.2-cli

# Instalar dependencias del sistema y extensiones
RUN apt-get update && apt-get install -y \
    zip unzip git curl libpng-dev libonig-dev libxml2-dev libzip-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Instalar Composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# Configurar el directorio de trabajo
WORKDIR /var/www

# Copiar el proyecto
COPY . .

# Instalar dependencias de PHP
RUN composer install --no-interaction --prefer-dist

# Exponer el puerto
EXPOSE 8000

# Comando por defecto: ejecutar el servidor de desarrollo
CMD php artisan serve --host=0.0.0.0 --port=8000
