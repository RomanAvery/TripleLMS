import './bootstrap';
import '../css/app.css';

import 'moment';

import { createApp, computed, h } from 'vue';
import { createInertiaApp, usePage } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from 'ziggy/vue.es.js';
import VueGtag from "vue-gtag";
import VueScreen from 'vue-screen';

import 'flowbite';

const app = document.getElementById('app');

createInertiaApp({
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, app, props, plugin }) {
        createApp({ render: () => h(app, props) })
            .use(plugin)
            .use(ZiggyVue)
            .use(VueGtag, {
                config: { id: props?.initialPage?.props?.settings?.ga },
                params: {
                    user_id: props?.initialPage?.props?.user?.id
                }
            })
            .use(VueScreen, 'tailwind')
            .mount(el);
    },
});

InertiaProgress.init({ color: '#4B5563' });

let sleep = ms => new Promise(resolve => setTimeout(resolve, ms));
window.sleep = sleep;
