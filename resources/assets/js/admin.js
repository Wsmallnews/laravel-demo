
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import iView from 'iview';
Vue.use(iView);

import Util from './libs/util.js';      // 导入 公共函数库
window.Util = Util;

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
// window.example = require('./vues/example.vue');
//
Vue.component('my-table', require('./vues/admins/includes/myTable.vue'));
Vue.component('my-upload', require('./vues/admins/includes/myUpload.vue'));
