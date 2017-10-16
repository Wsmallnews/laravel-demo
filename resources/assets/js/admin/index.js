import { router, store, iView } from './base';
import App from '@/components/admins/users/index.vue';

const routers = {

}

router.addRoutes(routers)

new Vue({
    el: '#app',
    router: router,
    store: store,
    render: h => h(App)
});
