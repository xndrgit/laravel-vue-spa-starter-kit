<script setup>
import AppHeader from './components/AppHeader.vue';
import { useAuthStore } from './stores/auth';

const auth = useAuthStore();
</script>

<template>
    <div class="min-h-screen">
        <AppHeader />

        <main v-if="auth.initialized">
            <RouterView />
        </main>
        <main v-else class="grid min-h-[calc(100vh-73px)] place-items-center px-4">
            <div class="text-center">
                <div class="mx-auto mb-4 size-10 animate-pulse bg-zinc-950"></div>
                <p class="text-sm font-semibold text-zinc-600">Restoring session...</p>
            </div>
        </main>
    </div>
</template>
