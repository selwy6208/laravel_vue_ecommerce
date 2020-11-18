window.Vue = require('vue');
window.$Bus = new Vue() // EventBus Service for communicating component via component


import router from './router.site'
import i18n, { selectedLocale } from './i18n'
// IMPORT THE STORE
import store from './store.site';

Vue.component('main-app', require('./site/comonents/MainApp.vue').default);

const app = new Vue({
    el: '#main-app',
    i18n,
    router,
    store
});

