<template>
    <section class="page-shell grid gap-8 lg:grid-cols-[240px_1fr]">
        <aside>
            <p class="eyebrow mb-3">Settings</p>
            <nav class="space-y-1" aria-label="Settings navigation">
                <RouterLink class="settings-link" to="/settings">
                    <FontAwesomeIcon icon="gear" />
                    Overview
                </RouterLink>
                <RouterLink class="settings-link" to="/settings/profile">
                    <FontAwesomeIcon icon="user" />
                    Profile
                </RouterLink>
                <RouterLink class="settings-link" to="/settings/security">
                    <FontAwesomeIcon icon="lock" />
                    Security
                </RouterLink>
            </nav>
        </aside>

        <div>
            <slot />
        </div>
    </section>
</template>
