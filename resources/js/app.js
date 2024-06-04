import { createApp, h } from 'vue';
import { createInertiaApp, Link } from '@inertiajs/vue3';
import NProgress from 'nprogress';
import { router, Head } from '@inertiajs/vue3';

import Layout from './Shared/Layout.vue';


createInertiaApp({
    progress: {
        delay: 250,
        color: '#29d',
        showSpinner: true,
    },
    resolve: async name => {
        let page = (await import(`./Pages/${name}.vue`)).default;

        if (page.layout === undefined) {
            page.layout = Layout;
        }

        return page;
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .component('Link', Link)
            .component('Head', Head)
            .mount(el)
    },
    title: title => `My App - ${title}`
});

 router.on('start', () => NProgress.start());
