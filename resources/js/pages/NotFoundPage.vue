<template>
    <section class="page-shell max-w-2xl py-20 text-center">
        <p class="eyebrow">404</p>
        <h1 class="mt-4 text-4xl font-bold tracking-tight text-zinc-950">Page not found</h1>
        <p class="mt-4 text-zinc-600">This Vue route is not defined in the starter kit.</p>
        <RouterLink
            to="/"
            class="button-primary mt-8 px-5 py-3"
        >
            <FontAwesomeIcon icon="house" />
            Go home
        </RouterLink>
    </section>
</template>
