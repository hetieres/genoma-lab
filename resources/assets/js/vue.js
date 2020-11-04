/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
window.toastr = require('../vendor/toastr/toastr.min');
window.Vue = require('vue');
window.VueLazyload = require('vue-lazyload');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
Vue.use(VueLazyload);
Vue.component("em-post", require("./components/PostComponent.vue"));
Vue.component("em-video", require("./components/VideoComponent.vue"));


Vue.component("em-news", require("./components/NewsComponent.vue"));
Vue.component("em-vehicles", require("./components/VehiclesComponent.vue"));
Vue.component("em-url", require("./components/UrlComponent.vue"));
Vue.component("em-team", require("./components/TeamReportComponent.vue"));

Vue.component("nm-users", require("./components/UsersComponent.vue"));
Vue.component("nm-user-profile", require("./components/UserProfileComponent.vue"));

const app = new Vue({
    el: '#main'
});