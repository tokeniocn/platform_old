
import G from './boot/global';
import $http from './boot/http';
import _ from 'lodash';
import Vue from 'vue';
import axios from 'axios';

window.G = G;
window._ = _;
window.Vue = Vue;
window.axios = axios;

window.$http = $http;

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     forceTLS: true
// });

/**
 * layui-admin
 */

// 初始化设置
layui.config({
  base: '/static/layuiadmin/' // 静态资源所在路径
}).extend({
  // layui-admin 组件
  index: 'lib/index',
}).use(['layer'], function () {
  const $ = layui.$;
  const $q = window.$q = Vue.prototype.$q;

  // iframe 下隐藏
  if (top == window) {
    $('[lay-iframe-hide]').show();
  }

  const headers = { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') };
  $http.defaults.headers.common = { ...headers, ...$http.defaults.headers.common };

  // ajax 基础设定
  $.ajaxSetup( {
    headers,
    // dataFilter: function(data, type) {
    //   console.log('dataFilter', arguments);
    //   return data;
    // },
    error: function(jqXHR, textStatus, errorMsg){ // 出错时默认的处理函数
      if (!$.isEmptyObject(jqXHR.responseJSON)) {
        var data = jqXHR.responseJSON;
        var msg = '';
        if (!$.isEmptyObject(data.errors)) {
          var errors = [];
          Object.keys(data.errors).forEach(function(key) {
            errors = errors.concat(data.errors[key]);
          })
          msg = '<ul><li>' + errors.join('</li><li>') + '</li></ul>';
        } else {
          msg = data.message;
        }

        layer.msg(
          msg,
          {
            offset: '15px',
            time: 2000
          }
        )
      }
    }
  });
});

