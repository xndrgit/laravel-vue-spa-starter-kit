@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('eyebrow', 'Admin dashboard')
@section('heading', 'Control center')

@section('content')
    <div class="grid gap-4 lg:grid-cols-3">
        <section class="section-card">
            <p class="text-sm font-semibold text-zinc-500">Admin</p>
            <p class="mt-2 text-2xl font-bold text-zinc-950">{{ auth()->user()->name }}</p>
            <p class="mt-1 text-sm text-zinc-500">{{ auth()->user()->email }}</p>
        </section>

        <section class="section-card">
            <p class="text-sm font-semibold text-zinc-500">Access</p>
            <p class="mt-2 text-2xl font-bold text-zinc-950">Administrator</p>
            <p class="mt-1 text-sm text-zinc-500">Protected by Laravel auth and admin middleware.</p>
        </section>

        <section class="section-card">
            <p class="text-sm font-semibold text-zinc-500">Website</p>
            <a class="mt-2 inline-flex items-center gap-2 text-2xl font-bold text-zinc-950 hover:underline" href="/">
                Open site
            </a>
            <p class="mt-1 text-sm text-zinc-500">Return to the Vue SPA landing page.</p>
        </section>
    </div>

    <section class="section-card mt-6">
        <h2 class="text-xl font-bold tracking-tight text-zinc-950">Blade admin foundation</h2>
        <p class="mt-2 max-w-2xl text-zinc-600">
            Add real admin modules here when the product needs operational tools.
        </p>
    </section>
@endsection
