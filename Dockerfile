FROM php:8.2-cli

# Instalar dependencias del sistema, Node.js y NPM
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpq-dev \
    curl \
    && curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && docker-php-ext-install pdo pdo_pgsql

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Directorio de trabajo
WORKDIR /var/www

# Copiar archivos
COPY . .

# Instalar dependencias PHP (Laravel)
RUN composer install --no-dev --optimize-autoloader

# Instalar dependencias Node y compilar CSS/JS (Vite)
RUN npm install
RUN npm run build

# Permisos
RUN chmod -R 775 storage bootstrap/cache

# Exponer puerto
EXPOSE 10000

# Comando de inicio
CMD php artisan migrate --force && php -S 0.0.0.0:$PORT -t public
