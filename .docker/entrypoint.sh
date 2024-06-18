#!/bin/sh

# Esperar a que la base de datos esté disponible
echo "Esperando a que la base de datos esté disponible..."
while ! mysqladmin ping -h"$DB_HOST" --silent; do
    sleep 1
done

echo "Limpiando rutas"
php artisan route:clear
echo "Limpiando configuración"
php artisan config:clear
echo "Limpiando caché"
php artisan cache:clear
composer dump-autoload -o
echo "Ejecutando migraciones"
php artisan migrate --force


# Ajustar permisos y propiedad de las claves de Passport
echo "Creando claves, ajustando permisos y propiedad de las claves de Passport..."
php artisan passport:keys --force

chown www-data:www-data storage/oauth-public.key storage/oauth-private.key
chmod 600 storage/oauth-public.key storage/oauth-private.key


# Iniciar PHP-FPM
echo "Iniciando PHP-FPM..."
php-fpm
