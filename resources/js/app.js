import './bootstrap';
import 'ekko-lightbox';
import './theme';
import Vue from 'vue';
import LazyLoad from 'vanilla-lazyload';
import ClipboardJS from 'clipboard';
import Swal from 'sweetalert2';
import * as Sentry from '@sentry/browser';
import * as Integrations from '@sentry/integrations';
import VueInternationalization from 'vue-i18n';
import Locale from './vue-i18n-locales.generated';

Sentry.init({
  dsn: process.env.MIX_SENTRY_PUBLIC_DSN,
  debug: process.env.MIX_APP_DEBUG,
  release: process.env.MIX_APP_TAG,
  environment: process.env.MIX_APP_ENV,
  integrations: [
    new Integrations.Vue({
      Vue,
      attachProps: true,
    }),
  ],
});

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
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// eslint-disable-next-line
const app = new Vue({
  el: '#app',
  i18n,
});

(new LazyLoad({
  elements_selector: '.lazy',
}))
  .update();
(new ClipboardJS('.btn-copy'))
  .on(
    'success',
    (event) => {
      Swal
        .mixin({
          toast: true,
          position: 'bottom-end',
          showConfirmButton: false,
          timer: 3000,
        })
        .fire({
          type: 'success',
          title: app.$t('global.copied'),
        });
      event.clearSelection();
    },
  );
$(() => {
  $('.easypiechart').easyPieChart();
});
