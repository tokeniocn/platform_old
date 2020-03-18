import Vue from 'vue';
import axios from 'axios';

const $http = axios.create({});

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
Vue.prototype.$axios = axios;
Vue.prototype.$http = $http;

export default $http;
