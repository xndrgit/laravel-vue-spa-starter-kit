<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', 'Admin') - {{ config('app.name', 'Laravel Vue SPA') }}</title>
        @vite(['resources/css/app.css'])
    </head>
    <body class="min-h-screen bg-zinc-50">
        <div class="min-h-screen lg:grid lg:grid-cols-[280px_1fr]">
            <aside class="border-b border-zinc-200 bg-zinc-950 text-zinc-100 lg:min-h-screen lg:border-b-0 lg:border-r lg:border-zinc-800">
                <div class="flex items-center justify-between px-5 py-5 lg:block">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                        <span class="grid size-10 place-items-center bg-zinc-100 text-xs font-bold text-zinc-950">
                            LV
                        </span>
                        <span>
                            <span class="block text-sm font-bold">Admin</span>
                            <span class="block text-xs text-zinc-400">{{ config('app.name', 'Laravel Vue SPA') }}</span>
                        </span>
                    </a>
                </div>

                <nav class="flex gap-1 overflow-x-auto px-3 pb-4 lg:block lg:space-y-1 lg:overflow-visible" aria-label="Admin navigation">
                    <a class="admin-nav-link {{ request()->routeIs('admin.dashboard') ? 'admin-nav-link-active' : '' }}" href="{{ route('admin.dashboard') }}">
                        <span aria-hidden="true">•</span>
                        Dashboard
                    </a>
                    <a class="admin-nav-link {{ request()->routeIs('admin.users') ? 'admin-nav-link-active' : '' }}" href="{{ route('admin.users') }}">
                        <span aria-hidden="true">•</span>
                        Users
                    </a>
                    <a class="admin-nav-link {{ request()->routeIs('admin.settings') ? 'admin-nav-link-active' : '' }}" href="{{ route('admin.settings') }}">
                        <span aria-hidden="true">•</span>
                        Settings
                    </a>
                    <a class="admin-nav-link {{ request()->routeIs('admin.system') ? 'admin-nav-link-active' : '' }}" href="{{ route('admin.system') }}">
                        <span aria-hidden="true">•</span>
                        System
                    </a>
                </nav>

                <div class="hidden px-5 py-5 lg:block">
                    <div class="mb-4 border border-zinc-800 p-3">
                        <p class="text-sm font-semibold text-white">{{ auth()->user()->name }}</p>
                        <p class="mt-1 break-words text-xs text-zinc-400">{{ auth()->user()->email }}</p>
                    </div>
                    <a class="inline-flex items-center gap-2 text-sm font-semibold text-zinc-300 hover:text-white" href="/">
                        View website
                    </a>
                </div>
            </aside>

            <div>
                <header class="border-b border-zinc-200 bg-white">
                    <div class="flex items-center justify-between gap-4 px-4 py-4 sm:px-6">
                        <div>
                            <p class="eyebrow">@yield('eyebrow', 'Admin')</p>
                            <h1 class="mt-1 text-xl font-bold tracking-tight text-zinc-950">@yield('heading', 'Dashboard')</h1>
                        </div>

                        <div class="flex items-center gap-3">
                            <a class="button-secondary hidden sm:inline-flex" href="/">
                                View website
                            </a>
                            <div class="hidden text-right sm:block">
                                <p class="text-sm font-semibold text-zinc-950">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-zinc-500">{{ auth()->user()->email }}</p>
                            </div>
                            <form method="POST" action="{{ route('admin.logout') }}">
                                @csrf
                                <button class="button-primary" type="submit">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </header>

                <main class="px-4 py-8 sm:px-6">
                    @yield('content')
                </main>
            </div>
        </div>
    </body>
</html>
