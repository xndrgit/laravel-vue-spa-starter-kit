<template>
    <section class="page-shell grid gap-10 lg:grid-cols-[1.15fr_0.85fr] lg:py-20">
        <div class="max-w-2xl">
            <p class="eyebrow mb-4">Laravel 12 / Vue 3 SPA</p>
            <h1 class="text-4xl font-bold tracking-tight text-zinc-950 sm:text-5xl">
                Start with auth, routing, account settings, and admin access already wired.
            </h1>
            <p class="mt-6 text-lg leading-8 text-zinc-600">
                Laravel Vue SPA Starter Kit gives you a production-shaped foundation for projects that need a Vue
                frontend, Sanctum session auth, password recovery, and a simple Blade admin area.
            </p>
            <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                <RouterLink
                    to="/register"
                    class="button-primary px-5 py-3"
                >
                    Try the account flow
                    <FontAwesomeIcon icon="arrow-right" />
                </RouterLink>
                <RouterLink
                    to="/about"
                    class="button-secondary px-5 py-3"
                >
                    Read the architecture
                </RouterLink>
            </div>
        </div>

        <div class="section-card">
            <div class="mb-5 flex items-center gap-3">
                <span class="grid size-10 place-items-center bg-zinc-950 text-white">
                    <FontAwesomeIcon icon="layer-group" />
                </span>
                <div>
                    <h2 class="font-semibold text-zinc-950">Included foundation</h2>
                    <p class="text-sm text-zinc-500">Ready to clone and extend.</p>
                </div>
            </div>
            <ul class="space-y-3 text-sm text-zinc-700">
                <li class="flex gap-2"><FontAwesomeIcon icon="check" class="mt-1 text-zinc-500" /> Laravel 12 backend and API routes</li>
                <li class="flex gap-2"><FontAwesomeIcon icon="check" class="mt-1 text-zinc-500" /> Vue 3 SPA with router guards</li>
                <li class="flex gap-2"><FontAwesomeIcon icon="check" class="mt-1 text-zinc-500" /> Sanctum cookie authentication</li>
                <li class="flex gap-2"><FontAwesomeIcon icon="check" class="mt-1 text-zinc-500" /> Account and password recovery screens</li>
                <li class="flex gap-2"><FontAwesomeIcon icon="check" class="mt-1 text-zinc-500" /> Blade admin area with protected access</li>
            </ul>
        </div>
    </section>
</template>
