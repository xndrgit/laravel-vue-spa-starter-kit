<template>
    <section class="page-shell max-w-3xl lg:py-20">
        <p class="eyebrow mb-4">Architecture</p>
        <h1 class="text-4xl font-bold tracking-tight text-zinc-950">A practical split between SPA and Laravel.</h1>
        <div class="mt-6 space-y-5 text-base leading-8 text-zinc-600">
            <p>
                Laravel Vue SPA Starter Kit keeps the customer-facing product in Vue 3 while Laravel owns sessions,
                APIs, password brokers, email verification, and admin-only Blade pages.
            </p>
            <p>
                Public and authenticated app routes belong to Vue. Admin routes belong to Laravel Blade. JSON routes stay under
                <code class="border border-zinc-200 bg-zinc-100 px-1.5 py-1 text-sm text-zinc-900">/api</code>.
            </p>
            <p>
                The included pages are intentionally focused: auth, account settings, security settings, and admin
                extension points. Replace the copy and add your product modules without untangling the foundation.
            </p>
        </div>
    </section>
</template>
