<script setup>
import { reactive, ref } from 'vue';
import { useAuthStore } from '../stores/auth';
import AuthShell from '../components/AuthShell.vue';
import { validationErrors } from '../lib/errors';

const auth = useAuthStore();
const loading = ref(false);
const errors = ref({});
const message = ref('');

const form = reactive({
    email: '',
});

const submit = async () => {
    loading.value = true;
    errors.value = {};
    message.value = '';

    try {
        const data = await auth.forgotPassword(form);
        message.value = data.message;
    } catch (error) {
        errors.value = validationErrors(error, { email: ['Unable to send reset link.'] });
    } finally {
        loading.value = false;
    }
};
</script>

<template>
    <AuthShell
        title="Recover access safely."
        description="Use the password reset flow after a production mailer is configured."
    >
        <h1 class="text-2xl font-bold tracking-tight text-zinc-950">Forgot password</h1>
        <p class="mt-2 text-sm text-zinc-600">Enter your email and we will send a reset link.</p>

        <div v-if="message" class="status-success mt-6">
            {{ message }}
        </div>

        <form class="mt-8 space-y-5" @submit.prevent="submit">
            <label class="block">
                <span class="form-label">Email</span>
                <input v-model="form.email" class="form-input" type="email" autocomplete="email" required>
                <span v-if="errors.email" class="form-error">{{ errors.email[0] }}</span>
            </label>

            <button class="form-button" type="submit" :disabled="loading">
                <FontAwesomeIcon icon="envelope" />
                {{ loading ? 'Sending link...' : 'Send reset link' }}
            </button>
        </form>

        <RouterLink class="mt-6 block text-center text-sm font-semibold text-zinc-950 hover:underline" to="/login">
            Back to login
        </RouterLink>
    </AuthShell>
</template>
