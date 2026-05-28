<script setup>
import { reactive, ref } from 'vue';
import { useAuthStore } from '../stores/auth';
import SettingsLayout from '../components/SettingsLayout.vue';
import PasswordChecklist from '../components/PasswordChecklist.vue';
import { validationErrors } from '../lib/errors';

const auth = useAuthStore();
const emailLoading = ref(false);
const passwordLoading = ref(false);
const emailErrors = ref({});
const passwordErrors = ref({});
const emailMessage = ref('');
const passwordMessage = ref('');

const emailForm = reactive({
    email: auth.user?.email || '',
    current_password: '',
});

const passwordForm = reactive({
    current_password: '',
    password: '',
    password_confirmation: '',
});

const updateEmail = async () => {
    emailLoading.value = true;
    emailErrors.value = {};
    emailMessage.value = '';

    try {
        const data = await auth.updateEmail(emailForm);
        emailForm.current_password = '';
        emailMessage.value = data.message || 'Verification link sent.';
    } catch (error) {
        emailErrors.value = validationErrors(error, { email: ['Email update failed.'] });
    } finally {
        emailLoading.value = false;
    }
};

const updatePassword = async () => {
    passwordLoading.value = true;
    passwordErrors.value = {};
    passwordMessage.value = '';

    try {
        await auth.updatePassword(passwordForm);
        passwordForm.current_password = '';
        passwordForm.password = '';
        passwordForm.password_confirmation = '';
        passwordMessage.value = 'Password updated.';
    } catch (error) {
        passwordErrors.value = validationErrors(error, { password: ['Password update failed.'] });
    } finally {
        passwordLoading.value = false;
    }
};
</script>

<template>
    <SettingsLayout>
        <div class="space-y-6">
        <div class="section-card">
            <h1 class="text-2xl font-bold tracking-tight text-zinc-950">Security</h1>
            <p class="mt-2 text-sm text-zinc-600">Email and password changes demonstrate the kit's sensitive account flow.</p>

            <div v-if="emailMessage" class="status-success mt-6">
                {{ emailMessage }}
            </div>

            <form class="mt-8 max-w-xl space-y-5" @submit.prevent="updateEmail">
                <label class="block">
                    <span class="form-label">Email</span>
                    <input v-model="emailForm.email" class="form-input" type="email" autocomplete="email" required>
                    <span v-if="emailErrors.email" class="form-error">{{ emailErrors.email[0] }}</span>
                </label>

                <label class="block">
                    <span class="form-label">Current password</span>
                    <input v-model="emailForm.current_password" class="form-input" type="password" autocomplete="current-password" required>
                    <span v-if="emailErrors.current_password" class="form-error">{{ emailErrors.current_password[0] }}</span>
                </label>

                <p class="status-warning">
                    We will send a verification link to the new address. Your account email changes only after that link is opened.
                </p>

                <p v-if="auth.user?.pending_email" class="status-info">
                    Pending verification: {{ auth.user.pending_email }}
                </p>

                <button class="button-primary" type="submit" :disabled="emailLoading">
                    <FontAwesomeIcon icon="envelope" />
                    {{ emailLoading ? 'Updating...' : 'Update email' }}
                </button>
            </form>
        </div>

        <div class="section-card">
            <h2 class="text-2xl font-bold tracking-tight text-zinc-950">Password</h2>
            <p class="mt-2 text-sm text-zinc-600">Change your password. Your current password is required.</p>

            <div v-if="passwordMessage" class="status-success mt-6">
                {{ passwordMessage }}
            </div>

            <form class="mt-8 max-w-xl space-y-5" @submit.prevent="updatePassword">
                <label class="block">
                    <span class="form-label">Current password</span>
                    <input v-model="passwordForm.current_password" class="form-input" type="password" autocomplete="current-password" required>
                    <span v-if="passwordErrors.current_password" class="form-error">{{ passwordErrors.current_password[0] }}</span>
                </label>

                <label class="block">
                    <span class="form-label">New password</span>
                    <input v-model="passwordForm.password" class="form-input" type="password" autocomplete="new-password" required>
                    <span v-if="passwordErrors.password" class="form-error">{{ passwordErrors.password[0] }}</span>
                </label>

                <PasswordChecklist :password="passwordForm.password" />

                <label class="block">
                    <span class="form-label">Confirm new password</span>
                    <input v-model="passwordForm.password_confirmation" class="form-input" type="password" autocomplete="new-password" required>
                </label>

                <button class="button-primary" type="submit" :disabled="passwordLoading">
                    <FontAwesomeIcon icon="key" />
                    {{ passwordLoading ? 'Updating...' : 'Update password' }}
                </button>
            </form>
        </div>
        </div>
    </SettingsLayout>
</template>
