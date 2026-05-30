<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Admin Login - {{ config('app.name', 'App') }}</title>
        @vite(['resources/css/app.css'])
    </head>
    <body class="min-h-screen bg-zinc-50">
        <main class="mx-auto grid min-h-screen max-w-6xl gap-8 px-4 py-10 sm:px-6 lg:grid-cols-[0.95fr_1.05fr] lg:items-center">
            <aside class="hidden lg:block">
                <p class="eyebrow">Admin access</p>
                <h1 class="mt-4 max-w-xl text-4xl font-bold tracking-tight text-zinc-950">Protected admin access.</h1>
                <p class="mt-5 max-w-lg text-base leading-8 text-zinc-600">
                    Sign in with an administrator account to access the protected admin area.
                </p>
                <a class="button-secondary mt-8" href="/">
                    View website
                </a>
            </aside>

            <section class="section-card mx-auto w-full max-w-md sm:p-8">
                <div class="mb-8">
                    <div class="mb-4 grid size-11 place-items-center bg-zinc-950 text-xs font-bold text-white">
                        AP
                    </div>
                    <h1 class="text-2xl font-bold tracking-tight text-zinc-950">Admin login</h1>
                    <p class="mt-2 text-sm text-zinc-600">Admins use the same users table with admin access enabled.</p>
                </div>

                @if ($errors->any())
                    <div class="status-danger mb-5">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.login.store') }}" class="space-y-5">
                    @csrf

                    <label class="block">
                        <span class="form-label">Email</span>
                        <input class="form-input" name="email" type="email" value="{{ old('email') }}" autocomplete="email" required autofocus>
                    </label>

                    <label class="block">
                        <span class="form-label">Password</span>
                        <input class="form-input" name="password" type="password" autocomplete="current-password" required>
                    </label>

                    <div class="flex items-center justify-between gap-4">
                        <label class="inline-flex min-h-11 items-center gap-2 text-sm font-medium text-zinc-700">
                            <input class="size-4 border-zinc-300 text-zinc-950" name="remember" type="checkbox" value="1">
                            Remember me
                        </label>
                        <a class="text-sm font-semibold text-zinc-950 hover:underline" href="/forgot-password">
                            Forgot password?
                        </a>
                    </div>

                    <button class="form-button" type="submit">Login</button>
                </form>
            </section>
        </main>
    </body>
</html>
