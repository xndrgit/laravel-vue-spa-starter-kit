<script setup>
defineProps({
    eyebrow: {
        type: String,
        default: 'Secure access',
    },
    title: {
        type: String,
        required: true,
    },
    description: {
        type: String,
        required: true,
    },
});
</script>

<template>
    <section class="mx-auto grid min-h-[calc(100vh-73px)] max-w-6xl gap-8 px-4 py-10 sm:px-6 lg:grid-cols-[0.95fr_1.05fr] lg:items-center lg:py-16">
        <aside class="hidden lg:block">
            <p class="eyebrow">{{ eyebrow }}</p>
            <h1 class="mt-4 max-w-xl text-4xl font-bold tracking-tight text-zinc-950">{{ title }}</h1>
            <p class="mt-5 max-w-lg text-base leading-8 text-zinc-600">{{ description }}</p>
            <div class="mt-8 space-y-3 text-sm text-zinc-700">
                <div class="flex items-center gap-3">
                    <span class="grid size-8 place-items-center bg-zinc-950 text-white">
                        <FontAwesomeIcon icon="shield-halved" />
                    </span>
                    Session-based authentication with CSRF protection.
                </div>
                <div class="flex items-center gap-3">
                    <span class="grid size-8 place-items-center bg-zinc-950 text-white">
                        <FontAwesomeIcon icon="lock" />
                    </span>
                    Password recovery and account security pages included.
                </div>
            </div>
        </aside>

        <div class="section-card mx-auto w-full max-w-md sm:p-8">
            <slot />
        </div>
    </section>
</template>
