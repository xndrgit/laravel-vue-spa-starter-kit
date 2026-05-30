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
