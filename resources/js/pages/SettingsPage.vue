<template>
    <SettingsLayout>
        <div class="section-card">
            <p class="eyebrow">Account settings</p>
            <h1 class="mt-3 text-3xl font-bold tracking-tight text-zinc-950">Included account settings.</h1>
            <p class="mt-4 max-w-2xl text-zinc-600">
                Use these screens as the starting point for profile, email, and password management in your app.
            </p>

            <div class="mt-6 grid gap-4 sm:grid-cols-2">
                <RouterLink class="border border-zinc-200 p-4 transition hover:bg-zinc-50 focus:outline-none focus:ring-2 focus:ring-zinc-950/10" to="/settings/profile">
                    <FontAwesomeIcon icon="user" class="mb-4 text-zinc-500" />
                    <h2 class="font-bold text-zinc-950">Profile</h2>
                    <p class="mt-1 text-sm text-zinc-500">Update the account display name.</p>
                </RouterLink>
                <RouterLink class="border border-zinc-200 p-4 transition hover:bg-zinc-50 focus:outline-none focus:ring-2 focus:ring-zinc-950/10" to="/settings/security">
                    <FontAwesomeIcon icon="lock" class="mb-4 text-zinc-500" />
                    <h2 class="font-bold text-zinc-950">Security</h2>
                    <p class="mt-1 text-sm text-zinc-500">Manage email and password changes.</p>
                </RouterLink>
            </div>
        </div>
    </SettingsLayout>
</template>

<script setup>
import SettingsLayout from '../components/SettingsLayout.vue';
</script>
