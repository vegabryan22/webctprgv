#!/usr/bin/env bash
set -Eeuo pipefail

TARGET="/www/wwwroot/ctprobertogamboa.ed.cr/html"
APP="$TARGET/.app"
BACKUPS="$TARGET/.deploy/backups"
STAMP="$(date +%Y%m%d_%H%M%S)"

[[ "$(pwd -P)" == "$TARGET/.deploy/actions-runner/_work/webctprgv/webctprgv" ]]
test -f artisan
test -f "$APP/.env"
mkdir -p "$BACKUPS"

tar -czf "$BACKUPS/gitops_pre_${STAMP}.tar.gz" \
    --exclude='.app/vendor' --exclude='.app/storage' \
    -C "$TARGET" .app index.php 2>/dev/null

rsync -a --delete \
    --exclude='.env' --exclude='storage/' --exclude='bootstrap/cache/' --exclude='.git/' \
    ./ "$APP"/

rsync -a --exclude='index.php' public/ "$TARGET"/

cd "$APP"
php artisan migrate --force
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:clear

test "$(curl -k -sS -o /dev/null -w '%{http_code}' \
    --resolve ctprobertogamboa.com:443:127.0.0.1 \
    https://ctprobertogamboa.com/)" = "200"

echo "Despliegue completado: $(tr -d '\r\n' < VERSION)"
