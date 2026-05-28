import { defineStore } from 'pinia';
import { api, csrf } from '../lib/api';

export const useAuthStore = defineStore('auth', {
    state: () => ({
        user: null,
        initialized: false,
    }),

    getters: {
        isAuthenticated: (state) => Boolean(state.user),
    },

    actions: {
        async fetchUser() {
            try {
                const { data } = await api.get('/user');
                this.user = data.user;
            } catch (error) {
                if (error.response?.status === 401) {
                    this.user = null;
                    return;
                }

                throw error;
            } finally {
                this.initialized = true;
            }
        },

        async login(credentials) {
            await csrf();
            const { data } = await api.post('/login', credentials);
            this.user = data.user;
        },

        async register(payload) {
            await csrf();
            const { data } = await api.post('/register', payload);
            this.user = data.user;
        },

        async logout() {
            await api.post('/logout');
            this.user = null;
        },

        async forgotPassword(payload) {
            await csrf();
            const { data } = await api.post('/forgot-password', payload);
            return data;
        },

        async resetPassword(payload) {
            await csrf();
            const { data } = await api.post('/reset-password', payload);
            return data;
        },

        async updateProfile(payload) {
            const { data } = await api.patch('/user/profile', payload);
            this.user = data.user;
            return data;
        },

        async updateEmail(payload) {
            const { data } = await api.patch('/user/email', payload);
            this.user = data.user;
            return data;
        },

        async updatePassword(payload) {
            const { data } = await api.put('/user/password', payload);
            return data;
        },
    },
});
