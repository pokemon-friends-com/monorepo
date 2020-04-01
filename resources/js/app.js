import Vue from 'vue';
import VueInternationalization from 'vue-i18n';
import Locale from './vue-i18n-locales.generated';

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

/**
 * Vue i18n
 */

Vue.use(VueInternationalization);
const i18n = new VueInternationalization({
  locale: document.head.querySelector('meta[name="locale"]'),
  fallbackLocale: 'en',
  messages: Locale,
});

/**
 * Vue filters
 */

Vue.filter('pkmnFriendCode', (code) => `${code.slice(0, 4)}-${code.slice(4, 8)}-${code.slice(8, 12)}`);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

const files = require.context('./components/', true, /\.vue$/i);
// eslint-disable-next-line
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
  i18n,
});
