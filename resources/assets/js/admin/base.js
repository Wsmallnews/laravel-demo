import '../bootstrap'
import Vue from 'vue'
import iView from 'iview'
import VueRouter from 'vue-router'
import Vuex from 'vuex';

Vue.use(VueRouter)
Vue.use(Vuex);

Vue.use(iView);

const router = new VueRouter({
    // mode: 'history',     //后端支持可开
    scrollBehavior: () => ({ y: 0 }),
    routes: Routers
})
router.beforeEach((to, from, next) => {
    // iView.LoadingBar.start();
    // Util.title(to.meta.title);
    next();
});

router.afterEach(() => {
    // iView.LoadingBar.finish();
    window.scrollTo(0, 0);
});


const store = new Vuex.Store({
    state: {

    },
    getters: {

    },
    mutations: {

    },
    actions: {

    }
});

export { router, store, iView }
