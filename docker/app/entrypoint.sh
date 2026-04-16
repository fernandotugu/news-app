#!/bin/sh

set -e

cd /var/www

# gera key se não existir
if [ -z "$APP_KEY" ] || [ "$APP_KEY" = "base64:" ]; then
  php artisan key:generate
fi

chmod -R 777 storage bootstrap/cache || true

exec php-fpm