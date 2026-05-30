import { createRouter, createWebHistory } from 'vue-router';
import { useAuthStore } from '../stores/auth';

import HomePage from '../pages/HomePage.vue';
import LoginPage from '../pages/LoginPage.vue';
import RegisterPage from '../pages/RegisterPage.vue';
import ForgotPasswordPage from '../pages/ForgotPasswordPage.vue';
import ResetPasswordPage from '../pages/ResetPasswordPage.vue';
import DashboardPage from '../pages/DashboardPage.vue';
import SettingsPage from '../pages/SettingsPage.vue';
import ProfileSettingsPage from '../pages/ProfileSettingsPage.vue';
import SecuritySettingsPage from '../pages/SecuritySettingsPage.vue';
import NotFoundPage from '../pages/NotFoundPage.vue';

const routes = [
    { path: '/', name: 'home', component: HomePage },
    { path: '/login', name: 'login', component: LoginPage, meta: { guest: true } },
    { path: '/register', name: 'register', component: RegisterPage, meta: { guest: true } },
    { path: '/forgot-password', name: 'forgot-password', component: ForgotPasswordPage, meta: { guest: true } },
    { path: '/reset-password/:token', name: 'reset-password', component: ResetPasswordPage, meta: { guest: true } },
    { path: '/dashboard', name: 'dashboard', component: DashboardPage, meta: { auth: true } },
    { path: '/settings', name: 'settings', component: SettingsPage, meta: { auth: true } },
    { path: '/settings/profile', name: 'settings.profile', component: ProfileSettingsPage, meta: { auth: true } },
    { path: '/settings/security', name: 'settings.security', component: SecuritySettingsPage, meta: { auth: true } },
    { path: '/:pathMatch(.*)*', name: 'not-found', component: NotFoundPage },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
    scrollBehavior: () => ({ top: 0 }),
});

router.beforeEach(async (to) => {
    const auth = useAuthStore();

    if (! auth.initialized) {
        await auth.fetchUser();
    }

    if (to.meta.auth && ! auth.isAuthenticated) {
        return { name: 'login', query: { redirect: to.fullPath } };
    }

    if (to.meta.guest && auth.isAuthenticated) {
        return { name: 'dashboard' };
    }

    return true;
});

export default router;
