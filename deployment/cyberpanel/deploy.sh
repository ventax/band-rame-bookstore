#!/usr/bin/env bash
set -euo pipefail

# Example:
# APP_DIR=/home/example.com/web-bookstore PHP_BIN=/usr/local/lsws/lsphp82/bin/php bash deployment/cyberpanel/deploy.sh

APP_DIR="${APP_DIR:-/home/example.com/web-bookstore}"
PHP_BIN="${PHP_BIN:-php}"
COMPOSER_BIN="${COMPOSER_BIN:-composer}"
NPM_BIN="${NPM_BIN:-npm}"
RUN_MIGRATIONS="${RUN_MIGRATIONS:-1}"
BUILD_ASSETS="${BUILD_ASSETS:-1}"
GENERATE_APP_KEY="${GENERATE_APP_KEY:-0}"

if [ ! -d "$APP_DIR" ]; then
  echo "APP_DIR not found: $APP_DIR"
  exit 1
fi

cd "$APP_DIR"

echo "[1/8] Installing PHP dependencies"
"$COMPOSER_BIN" install --no-interaction --no-dev --prefer-dist --optimize-autoloader

if [ "$BUILD_ASSETS" = "1" ]; then
  echo "[2/8] Building frontend assets"
  if command -v "$NPM_BIN" >/dev/null 2>&1; then
    "$NPM_BIN" ci || "$NPM_BIN" install
    "$NPM_BIN" run build
  else
    echo "npm command not found. Skip asset build."
  fi
else
  echo "[2/8] Skip asset build"
fi

if [ ! -f ".env" ]; then
  echo "[3/8] .env not found. Copying from .env.production.example"
  if [ -f "deployment/cyberpanel/.env.production.example" ]; then
    cp deployment/cyberpanel/.env.production.example .env
  else
    cp .env.example .env
  fi
  echo "Fill .env values first, then rerun deploy script."
  exit 1
fi

echo "[4/8] Running database migrations"
if [ "$RUN_MIGRATIONS" = "1" ]; then
  "$PHP_BIN" artisan migrate --force
else
  echo "Skip migrations"
fi

if [ "$GENERATE_APP_KEY" = "1" ]; then
  echo "[5/8] Generating app key"
  "$PHP_BIN" artisan key:generate --force
else
  echo "[5/8] Skip app key generation"
fi

echo "[6/8] Linking storage"
"$PHP_BIN" artisan storage:link || true

echo "[7/8] Optimizing Laravel"
"$PHP_BIN" artisan config:clear
"$PHP_BIN" artisan cache:clear
"$PHP_BIN" artisan route:clear
"$PHP_BIN" artisan view:clear
"$PHP_BIN" artisan config:cache
"$PHP_BIN" artisan route:cache
"$PHP_BIN" artisan view:cache

echo "[8/8] Fixing writable permissions"
chmod -R ug+rwx storage bootstrap/cache

echo "Deploy complete."
echo "Next: setup Cron for scheduler and queue worker in CyberPanel."
