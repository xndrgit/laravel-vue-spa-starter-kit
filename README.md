# Laravel Vue SPA Starter Kit

A clean Laravel 12 + Vue 3 starter kit for building session-authenticated SPAs with a small Blade admin area.

## Features

- Laravel 12 backend
- Vue 3 SPA frontend
- Vue Router routes and auth guards
- Pinia auth/session store
- Sanctum cookie-based SPA authentication
- Login, registration, logout, and remember-me support
- Password reset flow
- Profile settings
- Email change with password confirmation and verification
- Password change with current-password confirmation
- Admin login and protected Blade admin pages
- Tailwind CSS 4, Vite, and FontAwesome icons
- Feature tests for auth, account, and admin flows

## Tech Stack

- PHP `^8.2`
- Laravel `^12.0`
- Laravel Sanctum `^4.3`
- Vue `^3.5`
- Vue Router `^5.0`
- Pinia `^3.0`
- Tailwind CSS `^4.0`
- Vite `^6.0`
- PHPUnit `^11.5`
- MySQL or MariaDB

## Install

Clone the repository:

```bash
git clone https://github.com/YOUR-USERNAME/laravel-vue-spa-starter-kit.git
cd laravel-vue-spa-starter-kit
```

Install dependencies:

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
```

Create a MySQL/MariaDB database, then update `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_vue_spa
DB_USERNAME=root
DB_PASSWORD=
```

Run migrations:

```bash
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

No admin credentials are hard-coded or published.

To create a local admin user, set these values in your own `.env`:

```env
STARTER_ADMIN_NAME="Local Admin"
STARTER_ADMIN_EMAIL="admin@example.com"
STARTER_ADMIN_PASSWORD="choose-a-strong-password"
```

Then run:

```bash
php artisan migrate --seed
```

The seeder only creates this admin in the `local` environment and only when email and password are set.

Admin login:

```text
http://localhost:8000/admin/login
```

## Routes

Vue SPA:

- `/`
- `/about`
- `/login`
- `/register`
- `/forgot-password`
- `/reset-password/{token}`
- `/dashboard`
- `/settings`
- `/settings/profile`
- `/settings/security`

Blade admin:

- `/admin/login`
- `/admin/dashboard`
- `/admin/users`
- `/admin/settings`
- `/admin/system`
- `/admin/logout`

Laravel:

- `/api/*`
- `/sanctum/csrf-cookie`
- `/email-change/verify/{user}/{token}`

## Project Structure

```text
app/                    Laravel app code
database/               Migrations, factories, seeders
resources/js/           Vue SPA
resources/js/pages/     Vue pages
resources/js/router/    Vue Router config and guards
resources/js/stores/    Pinia stores
resources/views/app.blade.php
resources/views/admin/  Blade admin area
routes/api.php          API routes
routes/web.php          SPA, admin, verification routes
tests/Feature/          Feature tests
```

## Commands

```bash
npm run dev
npm run build
php artisan test
vendor/bin/pint
```

## Security Notes

- Do not commit `.env`.
- Do not publish real admin credentials.
- Configure a real mailer before using password reset or email verification in production.
- Review `SANCTUM_STATEFUL_DOMAINS` and `CORS_ALLOWED_ORIGINS` for your domain.
- Use HTTPS in production.
- Keep `APP_DEBUG=false` in production.

## Production Checklist

- Set `APP_ENV=production`
- Set `APP_DEBUG=false`
- Set a production database
- Configure mail
- Configure Sanctum/CORS domains
- Run `php artisan test`
- Run `npm run build`
- Deploy over HTTPS

## License

MIT
