# CyberPanel Deployment Helper

This folder contains production deployment helpers for this Laravel project.

## Files

- .env.production.example: production ENV template
- deploy.sh: deployment script for Composer, migration, cache, and permissions
- midtrans-callback-checklist.md: Midtrans webhook verification steps

## Quick Start

1. Upload project to server.
2. Copy and adjust .env.production.example into project .env.
3. Run deploy script:

```bash
APP_DIR=/home/your-domain/web-bookstore \
PHP_BIN=/usr/local/lsws/lsphp82/bin/php \
bash deployment/cyberpanel/deploy.sh
```

## Required Cron Jobs

### Scheduler (every minute)

```bash
/usr/local/lsws/lsphp82/bin/php /home/your-domain/web-bookstore/artisan schedule:run
```

### Queue Worker (every minute or process manager)

```bash
/usr/local/lsws/lsphp82/bin/php /home/your-domain/web-bookstore/artisan queue:work --tries=3 --timeout=120 --sleep=3
```

For stable queue processing, use process manager (Supervisor) when possible.
