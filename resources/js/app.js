import './bootstrap';
import '../css/app.css';
import "../css/custom-antdv.css"

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from 'ziggy-js';
import {Ziggy } from './ziggy';
const appName = import.meta.env.VITE_APP_NAME || 'Laravel';
import { Vue3Toastify } from 'vue3-toastify';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .use(Vue3Toastify,{autoClose: 3000})
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
