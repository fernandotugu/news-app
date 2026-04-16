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

# Vite fica em devDependencies: com bind mount + volume, instala na primeira subida
if [ ! -x node_modules/.bin/vite ]; then
  npm ci --no-audit --no-fund
fi

exec php-fpm