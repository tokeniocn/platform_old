import Vue from "vue";
import axios from "axios";

const $http = axios.create({
  timeout: 20000
});

$http.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
Vue.prototype.$axios = axios;
Vue.prototype.$http = $http;

export default $http;
