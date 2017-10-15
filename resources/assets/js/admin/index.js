import { router, store, iView } from './base';
import Vue from 'vue'
import App from '@/vues/admins/users/index.vue';

// const routers = {
//     // {
//     //     path: '/',
//     //     meta: {
//     //         title: '列表'
//     //     },
//     //     component: (resolve) => require(['@/vues/admins/users/index.vue'], resolve)
//     // },
// }

// router.addRoutes(routers)

new Vue({
    el: '#app',
    router: router,
    store: store,
    render: h => h(App)
});
