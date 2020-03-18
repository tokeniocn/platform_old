
const $http = window.$http = require('./boot/http');
window.Vue = require('vue');
window._ = require('lodash');

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

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
  var $ = window.jQuery = layui.$;

  // iframe 下隐藏
  if (top == window) {
    $('[lay-iframe-hide]').show();
  }

  // ajax 基础设定
  $.ajaxSetup( {
    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
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

