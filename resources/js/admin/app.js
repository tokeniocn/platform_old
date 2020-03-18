import Vue from 'vue';
import './boot/global';
import './boot/quasar';
import './boot/http';
import store from './store';
import './outer'; // 外部layui兼容实现

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

  if (process.env.NODE_ENV !== "production") {
    console.log(`Init Component [${name}] from ${key}`);
  }

  Vue.component(name, files(key).default);
});

new Vue({
  el: '#LAY_app',
  store
});
