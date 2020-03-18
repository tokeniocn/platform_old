import './outer';
import Vue from 'vue';
import iconSet from 'quasar/icon-set/material-icons';
import Quasar from 'quasar';

Vue.use(Quasar, { config: {}, iconSet: iconSet })

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

const files = require.context('./components', true, /\.vue$/i);
files.keys().map(key => {
  const name = key.split('/').pop().split('.')[0];
  console.log('init:' + name);
  Vue.component(name, files(key).default)
});

const app = new Vue({
  el: '#LAY_app',
});
