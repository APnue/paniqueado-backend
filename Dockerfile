FROM php:8.2-apache

# Copiar los archivos del proyecto al contenedor
COPY . /var/www/html/

# Dar permisos
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Habilitar módulos necesarios si usas MySQL, SQLite, etc.
RUN docker-php-ext-install mysqli pdo pdo_mysql
