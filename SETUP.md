# Run and deploy

Use the workspace root application, not `ninetyspoint.com/`.

## Local setup

Requirements: PHP 8.2+ with Composer-required extensions, Composer, a Node version supported by the locked Vite package, and MySQL/MariaDB for production. Automated tests use SQLite with `pdo_sqlite`.

1. Run `composer install` and `npm ci`.
2. On a new checkout, copy `.env.example` to `.env`. Never overwrite an existing configured `.env`.
3. Configure `APP_NAME`, `APP_URL`, database, mail, session and cache settings. Run `php artisan key:generate` only for a new application; changing an existing key invalidates encrypted data/sessions.
4. On a new local database run `php artisan migrate`. Do not use `migrate:fresh` against business data.
5. Set `STORE_ADMIN_EMAIL` and a unique `STORE_ADMIN_PASSWORD` of at least 12 characters. Run `php artisan db:seed --class=SuperAdminSeeder`. Remove the bootstrap password from the environment after initial provisioning. The seeder does not reset existing passwords or elevate existing customer accounts.
6. Run `npm run build`, then `php artisan serve`. Admin login is `/admin`; customer login is `/user-login`.
7. Add categories/products and shipping rows for `inside_dhaka`, `near_dhaka`, `outside_dhaka` in the admin. Prices and stock must be valid before checkout. Shipping charges are intentionally not guessed.
8. For SMS and social login, configure the keys in `.env.example` using your providers. OAuth redirect URLs must exactly match provider configuration. No online payment gateway is implemented; checkout currently supports COD.

## Verification

```text
php artisan test --compact
php tools/audit-routes.php
php artisan view:cache
npm run build
composer audit
```

Tests create isolated in-memory tables and do not call real SMS/payment services in the commerce tests. If an external environment forces a database connection, inspect `phpunit.xml` before running tests.

## Deployment

- Configure the web server document root to `<project>/public`. Keep `.env`, source, `vendor`, `tools`, and the nested duplicate out of the served document root.
- Set `APP_ENV=production`, `APP_DEBUG=false`, `APP_URL=https://...`, secure cookies and a persistent server-side session/cache driver supporting atomic locks. Checkout uses Laravel session blocking; cookie sessions are unsuitable.
- Install production Composer dependencies, build assets, run reviewed migrations, then `php artisan optimize`. Restart long-running workers when code changes.
- Back up the database and uploads, test restoration, configure mail/queue/monitoring, and exercise real guest/customer checkout and staff workflows on staging.
- Configure Nginx upload execution restrictions separately if using Nginx; Apache `.htaccess` files do not apply to it. Test Apache fallback root rewrites on the target hosting environment if it cannot point directly at `public`.
- Existing source bundles must not be exposed as subdirectories. Do not deploy `ninetyspoint.com/` with this application.

See `PROJECT_AUDIT.md` for unfinished functionality and remaining verification.
