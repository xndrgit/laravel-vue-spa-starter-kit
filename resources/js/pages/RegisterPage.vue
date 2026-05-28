<script setup>
import { reactive, ref } from 'vue';
import { useRouter } from 'vue-router';
import { useAuthStore } from '../stores/auth';
import AuthShell from '../components/AuthShell.vue';
import PasswordChecklist from '../components/PasswordChecklist.vue';
import { validationErrors } from '../lib/errors';

const auth = useAuthStore();
const router = useRouter();
const loading = ref(false);
const errors = ref({});

const form = reactive({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = async () => {
    loading.value = true;
    errors.value = {};

    try {
        await auth.register(form);
        router.push({ name: 'dashboard' });
    } catch (error) {
        errors.value = validationErrors(error, { email: ['Registration failed.'] });
    } finally {
        loading.value = false;
    }
};
</script>

<template>
    <AuthShell
        title="Start with a real account flow."
        description="Registration uses Laravel validation, secure password rules, Sanctum session auth, and a clear authenticated destination after signup."
    >
        <h1 class="text-2xl font-bold tracking-tight text-zinc-950">Register</h1>
        <p class="mt-2 text-sm text-zinc-600">Create a user account in the Vue SPA.</p>

        <form class="mt-8 space-y-5" @submit.prevent="submit">
            <label class="block">
                <span class="form-label">Name</span>
                <input v-model="form.name" class="form-input" type="text" autocomplete="name" required>
                <span v-if="errors.name" class="form-error">{{ errors.name[0] }}</span>
            </label>

            <label class="block">
                <span class="form-label">Email</span>
                <input v-model="form.email" class="form-input" type="email" autocomplete="email" required>
                <span v-if="errors.email" class="form-error">{{ errors.email[0] }}</span>
            </label>

            <label class="block">
                <span class="form-label">Password</span>
                <input v-model="form.password" class="form-input" type="password" autocomplete="new-password" required>
                <span v-if="errors.password" class="form-error">{{ errors.password[0] }}</span>
            </label>

            <PasswordChecklist :password="form.password" />

            <label class="block">
                <span class="form-label">Confirm password</span>
                <input v-model="form.password_confirmation" class="form-input" type="password" autocomplete="new-password" required>
            </label>

            <button class="form-button" type="submit" :disabled="loading">
                <FontAwesomeIcon icon="user-plus" />
                {{ loading ? 'Creating account...' : 'Register' }}
            </button>
        </form>

        <p class="mt-6 text-center text-sm text-zinc-600">
            Already registered?
            <RouterLink class="font-semibold text-zinc-950 hover:underline" to="/login">Login</RouterLink>
        </p>
    </AuthShell>
</template>
