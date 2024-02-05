/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import {publicPath,assetPath,userAccess} from "../../vue.config";

require('./bootstrap');

window.Vue = require('vue').default;
Vue.config.productionTip = false;

import VueRouter from "vue-router";
import {routes} from "./routes";

import Notifications from 'vue-notification'
Vue.use(Notifications)

import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
// import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
Vue.use(BootstrapVue)
Vue.use(IconsPlugin)

// import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue'; // If do not use webpack.mix.js
import { ZiggyVue } from 'ziggy';
import { Ziggy } from './ziggy';
Vue.use(ZiggyVue, Ziggy);


import Print from 'vue-print-nb'
// Global instruction
Vue.use(Print);
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);
// Vue.component('home', require('./components/Home').default);
Vue.mixin({
    data: function () {
        return {
            // message: 'hello',
            // foo: 'abc'
        }
    },
    methods: {
        addProjectPath: str => publicPath + str,
        assetPath: str => assetPath + str,
        StoragePath: str => publicPath + '/storage' + str,
        checkAccess:(page) => {
            // return page;
            if (window.Laravel.isLoggedin) {
                let userName = window.Laravel.user.username;
                let access = userAccess[userName];
                if (access && access.length) {
                    return access.includes(page) ? true : false;
                }
            }
            return false;
        }
    }
})
// Vue.prototype.$userId = document.querySelector("meta[name='user-id']").getAttribute('content');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.use(VueRouter);
const router = new VueRouter({
    mode: "history",
    base: publicPath,
    routes: routes
})
const DEFAULT_TITLE = 'BAFFA';
// router.afterEach((to, from) => {
//     Vue.nextTick(() => {
//         document.title = to.meta.title || DEFAULT_TITLE;
//     });
// });
router.beforeEach((to, from, next) => {
    document.title = to.meta.title || DEFAULT_TITLE;
    next();
});

const app = new Vue({
    el: '#app',
    router: router
});
