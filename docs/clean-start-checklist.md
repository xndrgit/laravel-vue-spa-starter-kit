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
