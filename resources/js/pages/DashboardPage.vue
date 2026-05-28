<script setup>
import { useAuthStore } from '../stores/auth';

const auth = useAuthStore();
</script>

<template>
    <section class="page-shell">
        <div class="mb-8 flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
            <div>
                <p class="eyebrow">Account</p>
                <h1 class="mt-3 text-3xl font-bold tracking-tight text-zinc-950">Welcome, {{ auth.user?.name }}</h1>
                <p class="mt-2 max-w-2xl text-zinc-600">This example account area shows the authenticated SPA foundation included in the kit.</p>
            </div>
            <RouterLink class="button-primary" to="/settings">
                <FontAwesomeIcon icon="gear" />
                Account settings
            </RouterLink>
        </div>

        <div class="grid gap-4 lg:grid-cols-3">
            <article class="section-card">
                <div class="mb-4 grid size-10 place-items-center bg-zinc-950 text-white">
                    <FontAwesomeIcon icon="user" />
                </div>
                <p class="text-sm font-semibold text-zinc-500">Name</p>
                <p class="mt-1 break-words text-lg font-bold text-zinc-950">{{ auth.user?.name }}</p>
            </article>

            <article class="section-card">
                <div class="mb-4 grid size-10 place-items-center bg-zinc-950 text-white">
                    <FontAwesomeIcon icon="envelope" />
                </div>
                <p class="text-sm font-semibold text-zinc-500">Email</p>
                <p class="mt-1 break-words text-lg font-bold text-zinc-950">{{ auth.user?.email }}</p>
            </article>

            <article class="section-card">
                <div class="mb-4 grid size-10 place-items-center bg-zinc-950 text-white">
                    <FontAwesomeIcon icon="shield-halved" />
                </div>
                <p class="text-sm font-semibold text-zinc-500">Access</p>
                <p class="mt-1 text-lg font-bold text-zinc-950">{{ auth.user?.is_admin ? 'User and admin' : 'User' }}</p>
            </article>
        </div>

        <div class="section-card mt-6">
            <h2 class="text-xl font-bold tracking-tight text-zinc-950">Included account flows</h2>
            <div class="mt-5 grid gap-3 sm:grid-cols-2">
                <RouterLink class="flex min-h-20 items-center gap-3 border border-zinc-200 p-4 transition hover:bg-zinc-50 focus:outline-none focus:ring-2 focus:ring-zinc-950/10" to="/settings/profile">
                    <FontAwesomeIcon icon="user" class="text-zinc-500" />
                    <span>
                        <span class="block font-semibold text-zinc-950">Review profile</span>
                        <span class="text-sm text-zinc-500">Profile editing is wired to the API.</span>
                    </span>
                </RouterLink>
                <RouterLink class="flex min-h-20 items-center gap-3 border border-zinc-200 p-4 transition hover:bg-zinc-50 focus:outline-none focus:ring-2 focus:ring-zinc-950/10" to="/settings/security">
                    <FontAwesomeIcon icon="lock" class="text-zinc-500" />
                    <span>
                        <span class="block font-semibold text-zinc-950">Update security</span>
                        <span class="text-sm text-zinc-500">Password and email security flows are included.</span>
                    </span>
                </RouterLink>
            </div>
        </div>
    </section>
</template>
