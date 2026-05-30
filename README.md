# Clean Laravel Vue App

Laravel 12 + Vue 3 application foundation with Sanctum cookie authentication, account settings, password reset, email-change verification, and a protected Blade admin login.

## Stack

| Layer | Tools |
| --- | --- |
| Backend | PHP 8.2+, Laravel 12, Laravel Sanctum |
| Frontend | Vue 3, Vue Router, Pinia, Tailwind CSS 4, FontAwesome |
| Build | Vite 6, npm |
| Quality | PHPUnit 11, Laravel Pint |

## Setup

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate
```

Start the app:

```bash
php artisan serve --host=localhost --port=8000
npm run dev
```

Open:

```text
http://localhost:8000
```

## Optional Local Admin

No admin credentials are hard-coded. To seed a local admin, set these values in `.env`:

```env
STARTER_ADMIN_NAME="Local Admin"
STARTER_ADMIN_EMAIL="admin@example.com"
STARTER_ADMIN_PASSWORD="choose-a-strong-password"
```

Then run:

```bash
php artisan migrate --seed
```

Admin login:

```text
http://localhost:8000/admin/login
```

## Useful Commands

| Command | Purpose |
| --- | --- |
| `npm run dev` | Start Vite |
| `npm run build` | Build frontend assets |
| `php artisan test` | Run backend tests |
| `vendor/bin/pint` | Format PHP code |

## Project Notes

- Keep `.env` private.
- Configure `SANCTUM_STATEFUL_DOMAINS` and `CORS_ALLOWED_ORIGINS` for each deployed environment.
- Configure a real mailer before using password reset and email-change verification in production.
- Run `php artisan test` and `npm run build` before deploy.
