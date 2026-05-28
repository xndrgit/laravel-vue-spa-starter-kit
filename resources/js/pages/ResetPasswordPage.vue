<script setup>
import { reactive, ref } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { useAuthStore } from '../stores/auth';
import AuthShell from '../components/AuthShell.vue';
import PasswordChecklist from '../components/PasswordChecklist.vue';
import { validationErrors } from '../lib/errors';

const auth = useAuthStore();
const route = useRoute();
const router = useRouter();
const loading = ref(false);
const errors = ref({});

const form = reactive({
    token: route.params.token,
    email: route.query.email || '',
    password: '',
    password_confirmation: '',
});

const submit = async () => {
    loading.value = true;
    errors.value = {};

    try {
        await auth.resetPassword(form);
        router.push({ name: 'login', query: { reset: 'success' } });
    } catch (error) {
        errors.value = validationErrors(error, { email: ['Unable to reset password.'] });
    } finally {
        loading.value = false;
    }
};
</script>

<template>
    <AuthShell
        title="Set a new password."
        description="Password reset requests complete through the same Laravel-backed account foundation."
    >
        <h1 class="text-2xl font-bold tracking-tight text-zinc-950">Reset password</h1>
        <p class="mt-2 text-sm text-zinc-600">Choose a new password for your account.</p>

        <form class="mt-8 space-y-5" @submit.prevent="submit">
            <label class="block">
                <span class="form-label">Email</span>
                <input v-model="form.email" class="form-input" type="email" autocomplete="email" required>
                <span v-if="errors.email" class="form-error">{{ errors.email[0] }}</span>
            </label>

            <label class="block">
                <span class="form-label">New password</span>
                <input v-model="form.password" class="form-input" type="password" autocomplete="new-password" required>
                <span v-if="errors.password" class="form-error">{{ errors.password[0] }}</span>
            </label>

            <PasswordChecklist :password="form.password" />

            <label class="block">
                <span class="form-label">Confirm new password</span>
                <input v-model="form.password_confirmation" class="form-input" type="password" autocomplete="new-password" required>
            </label>

            <button class="form-button" type="submit" :disabled="loading">
                <FontAwesomeIcon icon="key" />
                {{ loading ? 'Resetting...' : 'Reset password' }}
            </button>
        </form>
    </AuthShell>
</template>
