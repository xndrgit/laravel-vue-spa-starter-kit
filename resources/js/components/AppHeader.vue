<script setup>
import { onBeforeUnmount, onMounted, ref } from 'vue';
import { RouterLink, useRouter } from 'vue-router';
import { useAuthStore } from '../stores/auth';

const auth = useAuthStore();
const router = useRouter();
const open = ref(false);
const accountOpen = ref(false);
const accountMenu = ref(null);

const logout = async () => {
    await auth.logout();
    open.value = false;
    accountOpen.value = false;
    router.push({ name: 'home' });
};

const closeAccountMenu = (event) => {
    if (! accountMenu.value?.contains(event.target)) {
        accountOpen.value = false;
    }
};

const closeOnEscape = (event) => {
    if (event.key === 'Escape') {
        open.value = false;
        accountOpen.value = false;
    }
};

onMounted(() => {
    document.addEventListener('click', closeAccountMenu);
    document.addEventListener('keydown', closeOnEscape);
});

onBeforeUnmount(() => {
    document.removeEventListener('click', closeAccountMenu);
    document.removeEventListener('keydown', closeOnEscape);
});
</script>

<template>
    <header class="sticky top-0 z-40 border-b border-zinc-200 bg-white/90 backdrop-blur">
        <div class="mx-auto flex max-w-6xl items-center justify-between px-4 py-4 sm:px-6">
            <RouterLink to="/" class="flex items-center gap-3 font-semibold tracking-tight">
                <span class="grid size-10 place-items-center bg-zinc-950 text-xs font-bold text-white">
                    LV
                </span>
                <span class="text-lg">Laravel Vue SPA</span>
            </RouterLink>

            <button
                class="grid size-11 place-items-center border border-zinc-300 bg-white text-zinc-800 transition hover:bg-zinc-50 focus:outline-none focus:ring-2 focus:ring-zinc-950/10 md:hidden"
                type="button"
                aria-label="Toggle navigation"
                :aria-expanded="open"
                @click="open = !open"
            >
                <FontAwesomeIcon :icon="open ? 'xmark' : 'bars'" />
            </button>

            <nav
                :class="[
                    'absolute left-0 right-0 top-[73px] z-20 border-b border-zinc-200 bg-white px-4 py-4 md:static md:flex md:items-center md:gap-2 md:border-0 md:bg-transparent md:p-0',
                    open ? 'block' : 'hidden md:flex',
                ]"
            >
                <RouterLink class="nav-link" to="/" @click="open = false">Home</RouterLink>
                <RouterLink class="nav-link" to="/about" @click="open = false">Docs</RouterLink>

                <template v-if="auth.isAuthenticated">
                    <RouterLink class="nav-link" to="/dashboard" @click="open = false">Account</RouterLink>
                    <div ref="accountMenu" class="relative md:ml-2">
                        <button
                            class="mt-2 flex min-h-11 w-full items-center justify-between gap-3 border border-zinc-300 bg-white px-3 py-2 text-left text-sm font-semibold text-zinc-900 transition hover:bg-zinc-50 focus:outline-none focus:ring-2 focus:ring-zinc-950/10 md:mt-0 md:w-auto"
                            type="button"
                            :aria-expanded="accountOpen"
                            @click="accountOpen = !accountOpen"
                        >
                            <span class="min-w-0">
                                <span class="block truncate">{{ auth.user?.name }}</span>
                                <span class="block truncate text-xs font-medium text-zinc-500">{{ auth.user?.email }}</span>
                            </span>
                            <FontAwesomeIcon icon="chevron-down" class="text-xs text-zinc-500" />
                        </button>

                        <div
                            v-if="accountOpen"
                            class="right-0 z-30 mt-2 w-full border border-zinc-200 bg-white p-2 md:absolute md:w-64"
                        >
                            <RouterLink class="account-menu-link" to="/dashboard" @click="open = false; accountOpen = false">
                                <FontAwesomeIcon icon="gauge-high" />
                                Account
                            </RouterLink>
                            <RouterLink class="account-menu-link" to="/settings" @click="open = false; accountOpen = false">
                                <FontAwesomeIcon icon="gear" />
                                Settings
                            </RouterLink>
                            <a
                                v-if="auth.user?.is_admin"
                                class="account-menu-link"
                                href="/admin/dashboard"
                            >
                                <FontAwesomeIcon icon="shield-halved" />
                                Admin
                            </a>
                            <button class="account-menu-link w-full" type="button" @click="logout">
                                <FontAwesomeIcon icon="right-from-bracket" />
                                Logout
                            </button>
                        </div>
                    </div>
                </template>

                <template v-else>
                    <RouterLink class="nav-link" to="/login" @click="open = false">Login</RouterLink>
                    <RouterLink class="nav-action" to="/register" @click="open = false">
                        <FontAwesomeIcon icon="user-plus" />
                        Register
                    </RouterLink>
                </template>
            </nav>
        </div>
    </header>
</template>
