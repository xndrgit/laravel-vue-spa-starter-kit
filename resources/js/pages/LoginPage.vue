<script setup>
import { reactive, ref } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { useAuthStore } from '../stores/auth';
import AuthShell from '../components/AuthShell.vue';
import { validationErrors } from '../lib/errors';

const auth = useAuthStore();
const route = useRoute();
const router = useRouter();
const loading = ref(false);
const errors = ref({});

const form = reactive({
    email: '',
    password: '',
    remember: false,
});

const submit = async () => {
    loading.value = true;
    errors.value = {};

    try {
        await auth.login(form);
        router.push(route.query.redirect || { name: 'dashboard' });
    } catch (error) {
        errors.value = validationErrors(error, { email: ['Login failed.'] });
    } finally {
        loading.value = false;
    }
};
</script>

<template>
    <AuthShell
        title="Session auth, ready to extend."
        description="The kit uses Laravel sessions, Sanctum cookies, and CSRF-protected requests for a production-shaped SPA login flow."
    >
        <h1 class="text-2xl font-bold tracking-tight text-zinc-950">Login</h1>
        <p class="mt-2 text-sm text-zinc-600">Test the included authenticated account area.</p>

        <form class="mt-8 space-y-5" @submit.prevent="submit">
            <label class="block">
                <span class="form-label">Email</span>
                <input v-model="form.email" class="form-input" type="email" autocomplete="email" required>
                <span v-if="errors.email" class="form-error">{{ errors.email[0] }}</span>
            </label>

            <label class="block">
                <span class="form-label">Password</span>
                <input v-model="form.password" class="form-input" type="password" autocomplete="current-password" required>
                <span v-if="errors.password" class="form-error">{{ errors.password[0] }}</span>
            </label>

            <div class="flex items-center justify-between gap-4">
                <label class="inline-flex min-h-11 items-center gap-2 text-sm font-medium text-zinc-700">
                    <input v-model="form.remember" class="size-4 border-zinc-300 text-zinc-950" type="checkbox">
                    Remember me
                </label>
                <RouterLink class="text-sm font-semibold text-zinc-950 hover:underline" to="/forgot-password">
                    Forgot password?
                </RouterLink>
            </div>

            <button class="form-button" type="submit" :disabled="loading">
                <FontAwesomeIcon icon="right-to-bracket" />
                {{ loading ? 'Logging in...' : 'Login' }}
            </button>
        </form>

        <p class="mt-6 text-center text-sm text-zinc-600">
            No account?
            <RouterLink class="font-semibold text-zinc-950 hover:underline" to="/register">Create one</RouterLink>
        </p>
    </AuthShell>
</template>
