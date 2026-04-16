#!/bin/sh

set -e

cd /var/www

mkdir -p storage bootstrap/cache

if [ ! -f .env ]; then
  cp .env.example .env
fi

# Gera APP_KEY só se o .env ainda não tiver uma chave válida (evita depender de $APP_KEY no ambiente)
if ! grep -qE '^APP_KEY=base64:[A-Za-z0-9+/=]{40,}' .env 2>/dev/null; then
  php artisan key:generate --force
fi

chmod -R 777 storage bootstrap/cache || true

# PHP: volume `vendor` vazio na primeira subida — instala na imagem de runtime
if [ ! -f vendor/autoload.php ]; then
  composer install --no-interaction --prefer-dist --no-progress
fi

# Vite: volume `node_modules` vazio na primeira subida
if [ ! -x node_modules/.bin/vite ]; then
  npm ci --no-audit --no-fund
fi

exec php-fpm