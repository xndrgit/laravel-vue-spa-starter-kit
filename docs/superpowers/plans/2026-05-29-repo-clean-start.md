# Repo Clean Start Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Turn this Laravel/Vue starter repository into a clean project base with no starter-kit marketing, bundled agent assets, local generated artifacts, or placeholder feature surfaces.

**Architecture:** Keep the durable foundation: Laravel 12, Vue 3, Sanctum auth, password reset, profile/security settings, protected admin login, migrations, factories, and tests. Remove or neutralize project-contaminating starter-kit identity and extension-point pages so the next product can add real domain modules without first deleting demo copy.

**Tech Stack:** Laravel 12, PHP 8.2+, Vue 3, Vue Router, Pinia, Tailwind CSS 4, Vite 6, PHPUnit 11, Laravel Pint, npm.

---

## Cleanup Boundary

Keep:
- `app/Http/Controllers/Api/*` auth/account/password endpoints.
- `app/Http/Controllers/EmailChangeVerificationController.php`.
- `app/Http/Middleware/AdminMiddleware.php`.
- `app/Models/User.php`.
- `database/migrations/*`, `database/factories/UserFactory.php`, and `database/seeders/DatabaseSeeder.php`.
- Auth/settings Vue pages and shared components under `resources/js`.
- Admin login, admin dashboard, and admin layout.
- `tests/Feature/AuthSetupTest.php` and the parts of `tests/Feature/AdminSetupTest.php` that verify login, logout, and admin protection.

Remove or replace:
- `.agents/skills/**` bundled agent skills from the project repository.
- Starter-kit marketing and “Agents Ready” positioning from `README.md`.
- Starter-kit metadata from `composer.json`, `package.json`, `.env.example`, and visible app copy.
- Public SPA marketing pages that explain the starter instead of serving the future product.
- Placeholder admin pages: users, settings, and system.
- Generated local artifacts: `node_modules/`, `vendor/`, `.phpunit.result.cache`, and any `public/build` or `public/hot` if present.

## File Structure

**Delete**
- `.agents/`
- `.vscode/`
- `.phpunit.result.cache`
- `resources/js/pages/AboutPage.vue`
- `resources/views/admin/pages/users.blade.php`
- `resources/views/admin/pages/settings.blade.php`
- `resources/views/admin/pages/system.blade.php`

**Modify**
- `README.md`: rewrite as a clean project handoff README with setup, commands, and preserved foundation only.
- `composer.json`: rename package metadata away from the starter kit.
- `package.json`: move `@vitejs/plugin-vue` from `dependencies` to `devDependencies`; add a neutral `name`.
- `.env.example`: neutralize `APP_NAME`, database name, and admin seed variable comments.
- `.gitignore`: keep local/generated directories ignored and add `.agents/` if the folder is removed permanently.
- `routes/web.php`: remove placeholder admin page routes and keep `/admin/login`, `/admin/dashboard`, `/admin/logout`, SPA fallback, and email-change verification.
- `app/Http/Controllers/Admin/PageController.php`: delete if it only serves removed placeholder pages.
- `resources/js/router/index.js`: remove `/about` route and keep auth/account routes.
- `resources/js/pages/HomePage.vue`: replace starter-kit sales copy with a neutral authenticated-app entry page.
- `resources/js/pages/NotFoundPage.vue`: remove “starter kit” language.
- `resources/views/admin/login.blade.php`: remove starter-kit explanation copy.
- `tests/Feature/AuthSetupTest.php`: remove `/about` expectation and keep SPA fallback coverage.
- `tests/Feature/AdminSetupTest.php`: remove assertions for deleted `/admin/users`, `/admin/settings`, and `/admin/system`.

**Create**
- `docs/clean-start-checklist.md`: short checklist for future project initialization after this cleanup.

---

### Task 1: Establish Baseline And Inventory

**Files:**
- Read: repository root
- Modify: none
- Test: current test suite

- [ ] **Step 1: Record current status**

Run:

```bash
git status --short
```

Expected: list any existing uncommitted files. Do not revert user changes. If `docs/superpowers/plans/2026-05-29-repo-clean-start.md` is the only new file, continue.

- [ ] **Step 2: Run current backend tests**

Run:

```bash
php artisan test
```

Expected: existing feature tests pass before cleanup. If they fail, record the failing test names in the commit message body for the cleanup commit and continue only if the failures are unrelated to cleanup.

- [ ] **Step 3: Run current frontend build**

Run:

```bash
npm run build
```

Expected: Vite build completes and writes assets under `public/build`, which remains ignored.

- [ ] **Step 4: Commit baseline plan**

Run:

```bash
git add docs/superpowers/plans/2026-05-29-repo-clean-start.md
git commit -m "docs: plan clean project start"
```

Expected: one documentation commit containing only this plan.

---

### Task 2: Remove Bundled Agent And Editor Artifacts

**Files:**
- Delete: `.agents/`
- Delete: `.vscode/`
- Modify: `.gitignore`
- Test: `git status --short`

- [ ] **Step 1: Remove repository-bundled agent skills**

Run:

```bash
Remove-Item -LiteralPath .agents -Recurse -Force
```

Expected: `.agents/skills` and all bundled skill files are removed from the project repository.

- [ ] **Step 2: Remove editor-local folder**

Run:

```bash
Remove-Item -LiteralPath .vscode -Recurse -Force
```

Expected: `.vscode/extensions.json` is removed so the repo does not prescribe a personal editor setup.

- [ ] **Step 3: Harden ignore rules**

Edit `.gitignore` so it contains these project-local artifact rules:

```gitignore
/.phpunit.cache
/.phpunit.result.cache
/node_modules
/vendor
/public/build
/public/hot
/public/storage
/storage/*.key
/storage/pail
/database/database.sqlite
.env
.env.backup
.env.production
.phpactor.json
Homestead.json
Homestead.yaml
npm-debug.log
yarn-error.log
/auth.json
/.agents
/.fleet
/.idea
/.nova
/.vscode
/.zed
```

Expected: `.agents` is ignored after deletion; existing generated folders remain ignored.

- [ ] **Step 4: Verify artifact removal scope**

Run:

```bash
git status --short
```

Expected: deletions are limited to `.agents/**` and `.vscode/**`, plus `.gitignore` modification.

- [ ] **Step 5: Commit artifact cleanup**

Run:

```bash
git add .gitignore .agents .vscode
git commit -m "chore: remove bundled local agent artifacts"
```

Expected: commit removes agent/editor baggage and updates ignore rules.

---

### Task 3: Neutralize Project Identity And Metadata

**Files:**
- Modify: `composer.json`
- Modify: `package.json`
- Modify: `.env.example`
- Modify: `README.md`
- Test: `composer validate`, `npm install`

- [ ] **Step 1: Rename Composer package metadata**

In `composer.json`, replace the top metadata with:

```json
{
    "$schema": "https://getcomposer.org/schema.json",
    "name": "app/clean-laravel-vue-app",
    "type": "project",
    "description": "A clean Laravel 12 and Vue 3 application foundation with Sanctum authentication.",
    "keywords": ["laravel", "vue", "spa", "sanctum"],
    "license": "MIT",
```

Expected: no `starter-kit` package name, description, or keyword remains.

- [ ] **Step 2: Fix npm metadata and dependency placement**

In `package.json`, use this dependency layout:

```json
{
    "private": true,
    "name": "clean-laravel-vue-app",
    "type": "module",
    "scripts": {
        "build": "vite build",
        "dev": "vite"
    },
    "devDependencies": {
        "@tailwindcss/vite": "^4.0.0",
        "@vitejs/plugin-vue": "^6.0.7",
        "axios": "^1.7.4",
        "concurrently": "^9.0.1",
        "laravel-vite-plugin": "^1.2.0",
        "tailwindcss": "^4.0.0",
        "vite": "^6.0.11"
    },
    "dependencies": {
        "@fortawesome/fontawesome-svg-core": "^7.2.0",
        "@fortawesome/free-solid-svg-icons": "^7.2.0",
        "@fortawesome/vue-fontawesome": "^3.2.0",
        "pinia": "^3.0.4",
        "vue": "^3.5.35",
        "vue-router": "^5.0.7"
    }
}
```

Expected: build tooling lives in `devDependencies`; runtime Vue packages remain in `dependencies`.

- [ ] **Step 3: Refresh package lock**

Run:

```bash
npm install
```

Expected: `package-lock.json` updates to match `package.json`; no new packages are introduced beyond dependency section movement.

- [ ] **Step 4: Neutralize `.env.example`**

Change these values in `.env.example`:

```env
APP_NAME="App"
DB_DATABASE=app

# Optional local admin seed. Leave disabled unless local admin access is needed.
# STARTER_ADMIN_NAME="Local Admin"
# STARTER_ADMIN_EMAIL="admin@example.com"
# STARTER_ADMIN_PASSWORD=
```

Expected: no starter-kit app name or database name remains.

- [ ] **Step 5: Rewrite README as project setup documentation**

Replace `README.md` with the following content. Use triple backticks in the README exactly as shown inside this fenced block:

````markdown
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
````

Expected: README documents the foundation without advertising a starter kit or bundled agent workflows.

- [ ] **Step 6: Validate metadata**

Run:

```bash
composer validate
```

Expected: Composer schema is valid.

- [ ] **Step 7: Commit metadata cleanup**

Run:

```bash
git add composer.json package.json package-lock.json .env.example README.md
git commit -m "chore: neutralize project metadata"
```

Expected: commit contains only metadata and documentation cleanup.

---

### Task 4: Replace Starter-Kit SPA Copy With Neutral App Surface

**Files:**
- Modify: `resources/js/pages/HomePage.vue`
- Delete: `resources/js/pages/AboutPage.vue`
- Modify: `resources/js/pages/NotFoundPage.vue`
- Modify: `resources/js/router/index.js`
- Modify: `tests/Feature/AuthSetupTest.php`
- Test: `php artisan test --filter=AuthSetupTest`, `npm run build`

- [ ] **Step 1: Replace home page with neutral entry page**

Replace `resources/js/pages/HomePage.vue` with:

```vue
<template>
    <section class="page-shell grid gap-8 lg:grid-cols-[1fr_0.85fr] lg:py-20">
        <div class="max-w-2xl">
            <p class="eyebrow mb-4">Application</p>
            <h1 class="text-4xl font-bold tracking-tight text-zinc-950 sm:text-5xl">
                Build the product from a clean authenticated foundation.
            </h1>
            <p class="mt-6 text-lg leading-8 text-zinc-600">
                The core account flow is ready. Replace this page with the first real product screen when the project direction is set.
            </p>
            <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                <RouterLink to="/dashboard" class="button-primary px-5 py-3">
                    Open dashboard
                    <FontAwesomeIcon icon="arrow-right" />
                </RouterLink>
                <RouterLink to="/settings/profile" class="button-secondary px-5 py-3">
                    Account settings
                </RouterLink>
            </div>
        </div>

        <div class="section-card">
            <div class="mb-5 flex items-center gap-3">
                <span class="grid size-10 place-items-center bg-zinc-950 text-white">
                    <FontAwesomeIcon icon="shield-halved" />
                </span>
                <div>
                    <h2 class="font-semibold text-zinc-950">Ready foundation</h2>
                    <p class="text-sm text-zinc-500">Authentication and account basics are wired.</p>
                </div>
            </div>
            <ul class="space-y-3 text-sm text-zinc-700">
                <li class="flex gap-2"><FontAwesomeIcon icon="check" class="mt-1 text-zinc-500" /> Session login and registration</li>
                <li class="flex gap-2"><FontAwesomeIcon icon="check" class="mt-1 text-zinc-500" /> Password reset flow</li>
                <li class="flex gap-2"><FontAwesomeIcon icon="check" class="mt-1 text-zinc-500" /> Profile and security settings</li>
                <li class="flex gap-2"><FontAwesomeIcon icon="check" class="mt-1 text-zinc-500" /> Protected admin access</li>
            </ul>
        </div>
    </section>
</template>
```

Expected: visible starter-kit brand/copy is gone from the first screen.

- [ ] **Step 2: Remove About page route**

Delete:

```bash
Remove-Item -LiteralPath resources\js\pages\AboutPage.vue -Force
```

Then edit `resources/js/router/index.js` and remove the `/about` route import and route entry. The routes array should not contain `path: '/about'`.

Expected: `/about` falls through to the Vue 404 page instead of describing starter architecture.

- [ ] **Step 3: Neutralize 404 copy**

In `resources/js/pages/NotFoundPage.vue`, replace starter-kit wording with:

```vue
<template>
    <section class="page-shell max-w-2xl py-20">
        <p class="eyebrow mb-4">404</p>
        <h1 class="text-4xl font-bold tracking-tight text-zinc-950">Page not found.</h1>
        <p class="mt-4 text-zinc-600">This route is not available.</p>
        <RouterLink to="/" class="button-primary mt-8 inline-flex px-5 py-3">
            Go home
        </RouterLink>
    </section>
</template>
```

Expected: no starter-kit phrase remains in 404.

- [ ] **Step 4: Update SPA route tests**

In `tests/Feature/AuthSetupTest.php`, remove this line from `test_spa_pages_and_fallback_are_served`:

```php
$this->get('/about')->assertOk();
```

Keep this existing assertion in the same test:

```php
$this->get('/unknown-front-end-page')->assertOk();
```

Expected: Laravel still serves SPA fallback after the `/about` route expectation is removed; Vue handles unknown routes.

- [ ] **Step 5: Verify SPA cleanup**

Run:

```bash
php artisan test --filter=AuthSetupTest
```

Expected: auth setup tests pass.

- [ ] **Step 6: Verify frontend build**

Run:

```bash
npm run build
```

Expected: Vite build succeeds with no missing `AboutPage.vue` import.

- [ ] **Step 7: Commit SPA cleanup**

Run:

```bash
git add resources/js/pages resources/js/router/index.js tests/Feature/AuthSetupTest.php
git commit -m "chore: remove starter spa copy"
```

Expected: commit removes starter marketing page and updates coverage.

---

### Task 5: Remove Placeholder Admin Pages

**Files:**
- Modify: `routes/web.php`
- Delete: `app/Http/Controllers/Admin/PageController.php`
- Delete: `resources/views/admin/pages/users.blade.php`
- Delete: `resources/views/admin/pages/settings.blade.php`
- Delete: `resources/views/admin/pages/system.blade.php`
- Modify: `resources/views/admin/layouts/app.blade.php`
- Modify: `resources/views/admin/login.blade.php`
- Modify: `tests/Feature/AdminSetupTest.php`
- Test: `php artisan test --filter=AdminSetupTest`

- [ ] **Step 1: Remove placeholder admin route controller usage**

In `routes/web.php`, remove:

```php
use App\Http\Controllers\Admin\PageController as AdminPageController;
```

Remove these routes from the authenticated admin group:

```php
Route::get('/users', [AdminPageController::class, 'users'])->name('users');
Route::get('/settings', [AdminPageController::class, 'settings'])->name('settings');
Route::get('/system', [AdminPageController::class, 'system'])->name('system');
```

Expected: admin exposes only login, dashboard, and logout until real admin modules are added.

- [ ] **Step 2: Delete unused placeholder controller and views**

Run:

```bash
Remove-Item -LiteralPath app\Http\Controllers\Admin\PageController.php -Force
Remove-Item -LiteralPath resources\views\admin\pages\users.blade.php -Force
Remove-Item -LiteralPath resources\views\admin\pages\settings.blade.php -Force
Remove-Item -LiteralPath resources\views\admin\pages\system.blade.php -Force
```

Expected: removed files were only serving empty extension-point copy.

- [ ] **Step 3: Remove admin navigation links to deleted pages**

In `resources/views/admin/layouts/app.blade.php`, remove navigation items or links that reference:

```php
route('admin.users')
route('admin.settings')
route('admin.system')
```

Expected: admin layout does not link to deleted routes.

- [ ] **Step 4: Neutralize admin login copy**

In `resources/views/admin/login.blade.php`, replace:

```text
The starter kit ships with Blade admin routes, session login, and an explicit admin authorization check.
```

with:

```text
Sign in with an administrator account to access the protected admin area.
```

Expected: login page no longer advertises starter-kit internals.

- [ ] **Step 5: Update admin tests**

In `tests/Feature/AdminSetupTest.php`, remove these assertions from `test_admin_can_login_and_logout`:

```php
$this->get('/admin/users')->assertOk();
$this->get('/admin/settings')->assertOk();
$this->get('/admin/system')->assertOk();
```

Delete the entire `test_admin_pages_require_admin_access` method.

Add this method:

```php
public function test_removed_placeholder_admin_pages_are_not_available(): void
{
    $admin = User::factory()->create(['is_admin' => true]);

    foreach (['/admin/users', '/admin/settings', '/admin/system'] as $path) {
        $this->actingAs($admin)->get($path)->assertNotFound();
    }
}
```

Expected: tests now lock in that placeholder routes are gone.

- [ ] **Step 6: Verify admin cleanup**

Run:

```bash
php artisan test --filter=AdminSetupTest
```

Expected: admin tests pass and deleted routes return 404.

- [ ] **Step 7: Commit admin cleanup**

Run:

```bash
git add routes/web.php app/Http/Controllers/Admin/PageController.php resources/views/admin tests/Feature/AdminSetupTest.php
git commit -m "chore: remove placeholder admin pages"
```

Expected: commit removes empty admin surfaces and updates tests.

---

### Task 6: Remove Local Generated Artifacts From Working Copy

**Files:**
- Delete from working copy only: `node_modules/`, `vendor/`, `.phpunit.result.cache`, `public/build/`, `public/hot`
- Modify: none
- Test: reinstall and rebuild commands

- [ ] **Step 1: Remove generated dependency/build folders**

Run these commands only after confirming no local-only edits exist inside these ignored paths:

```bash
Remove-Item -LiteralPath node_modules -Recurse -Force
Remove-Item -LiteralPath vendor -Recurse -Force
Remove-Item -LiteralPath .phpunit.result.cache -Force
```

If present, also run:

```bash
Remove-Item -LiteralPath public\build -Recurse -Force
Remove-Item -LiteralPath public\hot -Force
```

Expected: working directory no longer contains heavy generated folders or cache files.

- [ ] **Step 2: Reinstall PHP dependencies**

Run:

```bash
composer install
```

Expected: `vendor/` is recreated from `composer.lock`; no lockfile changes.

- [ ] **Step 3: Reinstall frontend dependencies**

Run:

```bash
npm install
```

Expected: `node_modules/` is recreated from `package-lock.json`; no lockfile changes after Task 3.

- [ ] **Step 4: Re-run full verification**

Run:

```bash
vendor/bin/pint --test
php artisan test
npm run build
```

Expected: formatter check, backend tests, and frontend build all pass.

- [ ] **Step 5: Confirm generated artifacts are ignored**

Run:

```bash
git status --short
```

Expected: `node_modules/`, `vendor/`, `.phpunit.result.cache`, and `public/build/` do not appear as untracked files.

---

### Task 7: Add Clean-Start Checklist

**Files:**
- Create: `docs/clean-start-checklist.md`
- Test: none

- [ ] **Step 1: Create future project checklist**

Create `docs/clean-start-checklist.md`:

```markdown
# Clean Start Checklist

Use this before adding product-specific work.

- Rename `APP_NAME` in `.env` and `.env.example`.
- Rename Composer package metadata in `composer.json` if the project name is known.
- Rename npm package metadata in `package.json` if the project name is known.
- Configure the real database in `.env`.
- Configure mail before relying on password reset or email-change verification.
- Configure `SANCTUM_STATEFUL_DOMAINS` and `CORS_ALLOWED_ORIGINS` for the chosen frontend URL.
- Replace `resources/js/pages/HomePage.vue` with the first product screen.
- Add real admin modules before adding admin navigation links.
- Run `vendor/bin/pint --test`, `php artisan test`, and `npm run build` before the first feature commit.
```

Expected: checklist gives future contributors the remaining project-specific setup steps.

- [ ] **Step 2: Commit checklist**

Run:

```bash
git add docs/clean-start-checklist.md
git commit -m "docs: add clean start checklist"
```

Expected: checklist is committed separately from code cleanup.

---

### Task 8: Final Verification And Search

**Files:**
- Read: whole repository
- Modify: any file where the search reveals leftover starter contamination
- Test: full suite and build

- [ ] **Step 1: Search for leftover starter language**

Run:

```bash
rg "Starter Kit|starter kit|Agents Ready|agent-assisted|\\.agents|extension point|Read the architecture|Try the account flow|laravel_vue_spa"
```

Expected: no matches in source or docs except this implementation plan, if it remains in the repo.

- [ ] **Step 2: Search for removed admin routes**

Run:

```bash
rg "admin\\.users|admin\\.settings|admin\\.system|/admin/users|/admin/settings|/admin/system"
```

Expected: no matches except tests that assert removed routes are unavailable.

- [ ] **Step 3: Run formatter check**

Run:

```bash
vendor/bin/pint --test
```

Expected: no PHP formatting changes required.

- [ ] **Step 4: Run full backend tests**

Run:

```bash
php artisan test
```

Expected: all feature tests pass.

- [ ] **Step 5: Run frontend build**

Run:

```bash
npm run build
```

Expected: Vite build succeeds.

- [ ] **Step 6: Commit any final cleanup fixes**

If Task 8 required source edits, run:

```bash
git add README.md composer.json package.json package-lock.json .env.example .gitignore routes resources app tests docs
git commit -m "chore: finish clean project baseline"
```

Expected: final commit only contains residual cleanup from the searches.

---

## Self-Review

**Spec coverage:** The plan addresses repo contamination before project start: bundled agent files, editor-local files, starter branding, placeholder app/admin pages, generated artifacts, metadata, docs, and verification.

**Placeholder scan:** No task depends on unspecified “later” work. Product-specific naming remains intentionally neutral as `App` and `clean-laravel-vue-app` until the actual project name exists.

**Risk notes:** Removing `.agents/` is correct for a clean application repository, but it removes bundled local skills from the repo. The user-level skills remain available outside this project. Removing placeholder admin routes is safer than leaving fake surfaces because future admin modules can add routes and tests when they have real behavior.
