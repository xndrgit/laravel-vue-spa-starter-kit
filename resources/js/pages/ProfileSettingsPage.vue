<script setup>
import { reactive, ref, watchEffect } from 'vue';
import { useAuthStore } from '../stores/auth';
import SettingsLayout from '../components/SettingsLayout.vue';
import { validationErrors } from '../lib/errors';

const auth = useAuthStore();
const loading = ref(false);
const errors = ref({});
const message = ref('');

const form = reactive({
    name: '',
});

watchEffect(() => {
    form.name = auth.user?.name || '';
});

const submit = async () => {
    loading.value = true;
    errors.value = {};
    message.value = '';

    try {
        await auth.updateProfile(form);
        message.value = 'Profile updated.';
    } catch (error) {
        errors.value = validationErrors(error, { name: ['Profile update failed.'] });
    } finally {
        loading.value = false;
    }
};
</script>

<template>
    <SettingsLayout>
        <div class="section-card">
            <h1 class="text-2xl font-bold tracking-tight text-zinc-950">Profile</h1>
            <p class="mt-2 text-sm text-zinc-600">Your name can be changed here. Email changes require password confirmation in Security.</p>

            <div v-if="message" class="status-success mt-6">
                {{ message }}
            </div>

            <form class="mt-8 max-w-xl space-y-5" @submit.prevent="submit">
                <label class="block">
                    <span class="form-label">Name</span>
                    <input v-model="form.name" class="form-input" type="text" autocomplete="name" required>
                    <span v-if="errors.name" class="form-error">{{ errors.name[0] }}</span>
                </label>

                <button class="button-primary" type="submit" :disabled="loading">
                    <FontAwesomeIcon icon="circle-check" />
                    {{ loading ? 'Saving...' : 'Save profile' }}
                </button>
            </form>
        </div>
    </SettingsLayout>
</template>
