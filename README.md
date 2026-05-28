# Laravel Vue SPA Starter Kit

**Ship a real Laravel 12 + Vue 3 SPA faster.**  
This starter kit gives you cookie-based Sanctum auth, a Vue router app, account settings, password reset, email change verification, a protected Blade admin area, tests, and bundled Codex skills for agent-assisted development.

## Why This Repo

| You need | This repo gives you |
| --- | --- |
| A Laravel + Vue SPA without Inertia | **Vue Router**, **Pinia**, **Vite**, and Laravel API routes |
| Session-safe authentication | **Sanctum cookie auth**, CSRF support, login, register, logout |
| Account workflows | Profile updates, password changes, password reset, email change verification |
| A small admin surface | Separate Blade admin login and protected admin pages |
| Agent-ready project workflows | Codex skills in `.agents/skills` for design, planning, copy, review, and implementation support |

## Stack

| Layer | Tools |
| --- | --- |
| Backend | **PHP 8.2+**, **Laravel 12**, **Laravel Sanctum** |
| Frontend | **Vue 3**, **Vue Router 5**, **Pinia 3**, **Tailwind CSS 4**, **FontAwesome** |
| Build | **Vite 6**, npm |
| Quality | **PHPUnit 11**, **Laravel Pint** |
| Database | MySQL or MariaDB |

## Included

| Area | Included pieces |
| --- | --- |
| SPA pages | Home, about, login, register, forgot password, reset password, dashboard, settings, profile, security, 404 |
| API auth | Register, login, current user, logout |
| Account API | Profile update, email update, password update |
| Admin | Login, dashboard, users, settings, system, logout |
| Security defaults | Throttled auth routes, signed email-change verification, no published credentials |
| Tests | Feature tests for auth and admin setup |

## Quick Start

```bash
git clone https://github.com/xndrgit/laravel-vue-spa-starter-kit.git
cd laravel-vue-spa-starter-kit

composer install
npm install
cp .env.example .env
php artisan key:generate
```

Create a database, then update `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_vue_spa
DB_USERNAME=root
DB_PASSWORD=
```

Run and open:

```bash
php artisan migrate
php artisan serve --host=localhost --port=8000
npm run dev
```

```text
http://localhost:8000
```

## Optional Local Admin

No admin credentials are hard-coded. To seed a local admin, add these values to your own `.env`:

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

## Project Structure

| Path | Purpose |
| --- | --- |
| `app/Http/Controllers/Api` | SPA auth, password reset, and account endpoints |
| `app/Http/Controllers/Admin` | Blade admin authentication and pages |
| `app/Http/Middleware/AdminMiddleware.php` | Admin route protection |
| `app/Notifications/VerifyPendingEmail.php` | Pending email verification notification |
| `database/migrations` | Users, cache, jobs, and pending-email schema |
| `database/seeders` | Optional local admin seeding |
| `resources/js` | Vue SPA entry, pages, components, router, and store |
| `resources/views/admin` | Protected Blade admin UI |
| `routes/api.php` | JSON API routes |
| `routes/web.php` | SPA fallback, admin routes, email verification route |
| `tests/Feature` | Feature coverage for auth and admin setup |
| `.agents/skills` | Codex skills bundled with the project |

## Vue Components

| Component | Role |
| --- | --- |
| `AppHeader.vue` | Main SPA navigation and session actions |
| `AuthShell.vue` | Shared layout for auth pages |
| `PasswordChecklist.vue` | Password requirement feedback |
| `SettingsLayout.vue` | Settings section navigation and layout |
| `stores/auth.js` | Pinia session state and auth actions |
| `router/index.js` | Vue routes and auth guards |

## Bundled Codex Skills

The repo includes reusable Codex skills in `.agents/skills` so future work can follow repeatable workflows.

| Skill | Use it for |
| --- | --- |
| `brainstorming` | Shape ideas into clear specs before implementation |
| `writing-plans` | Turn approved requirements into task-by-task implementation plans |
| `frontend-design` | Build polished frontend pages and components |
| `impeccable` | Improve UI craft, hierarchy, accessibility, motion, and UX copy |
| `web-design-guidelines` | Review UI against web interface best practices |
| `copywriting` | Write concise product, README, and marketing copy |
| `find-skills` | Discover installable skills for specialized work |
| `grill-me` | Stress-test plans with structured questioning |
| `ui-ux-pro-max` | Plan, build, and review UI/UX across web and mobile patterns |
| `sleek-design-mobile-apps` | Design mobile app screens and flows |
| `caveman` | Switch to ultra-compact technical communication |
| `caveman-compress` | Compress memory and instruction files while preserving meaning |
| `using-superpowers` | Skill-discovery guardrail for agent workflows |

## Useful Commands

| Command | Purpose |
| --- | --- |
| `npm run dev` | Start Vite |
| `npm run build` | Build frontend assets |
| `php artisan test` | Run feature tests |
| `vendor/bin/pint` | Format PHP code |

## Production Notes

- Keep `.env` private.
- Use `APP_ENV=production` and `APP_DEBUG=false`.
- Configure a production database and mailer.
- Review `SANCTUM_STATEFUL_DOMAINS` and `CORS_ALLOWED_ORIGINS`.
- Serve over HTTPS.
- Run `php artisan test` and `npm run build` before deploy.

## Contributing

Pull requests are welcome.

For a clean contribution:

1. Fork the repo.
2. Create a focused branch.
3. Keep changes small and documented.
4. Run the relevant tests and formatter.
5. Open a PR with the problem, solution, and verification steps.

## License

Released under the **MIT License**.
