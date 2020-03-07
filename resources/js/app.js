/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('moment');
require('admin-lte');
require('admin-lte/plugins/select2/js/select2.full');
require('admin-lte/plugins/select2/js/i18n/fr');
require('admin-lte/plugins/select2/js/i18n/en');
require('admin-lte/plugins/sweetalert2/sweetalert2.all');
require('admin-lte/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4');
const Vue = require('vue');

Vue.filter('pkmnFriendCode', (code) => `${code.slice(0, 4)}-${code.slice(4, 8)}-${code.slice(8, 12)}`);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

const files = require.context('./components/', true, /\.vue$/i);
files.keys().map((key) => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

/**
 * laravel/passport components.
 */

Vue.component('passport-clients', require('./components/passport/Clients.vue').default);
Vue.component('passport-authorized-clients', require('./components/passport/AuthorizedClients.vue').default);
Vue.component('passport-personal-access-tokens', require('./components/passport/PersonalAccessTokens.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// eslint-disable-next-line
const app = new Vue({
  el: '#template',
});
