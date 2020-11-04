// window._           = require('lodash');

// Config axios
window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

const token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['Accept'] = 'application/json';
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

// Vue
window.Vue         = require('vue');
window.VueLazyload = require('vue-lazyload');

Vue.use(VueLazyload, {lazyComponent: true});
Vue.component("nm-news-featured", require("./components/NewsFeaturedComponent.vue"));
Vue.component("nm-news-home", require("./components/NewsComponent.vue"));
Vue.component("nm-news-box-home", require("./components/NewsBoxComponent.vue"));

const app = new Vue({
    el: '#main'
});