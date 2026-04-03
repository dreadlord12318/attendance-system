import { createInertiaApp } from '@inertiajs/vue3';
import { initializeTheme } from '@/composables/useAppearance';
import AppLayout from '@/layouts/AppLayout.vue';
import AuthLayout from '@/layouts/AuthLayout.vue';
import SettingsLayout from '@/layouts/settings/Layout.vue';
import MainLayout from '@/layouts/MainLayout.vue'; 

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    // ...
    layout: (name) => {
        switch (true) {
            // Force NOTHING as a default. 
            // This means if you don't manually wrap a page, it has NO layout.
            default:
                return null; 
        }
    },
});

initializeTheme();