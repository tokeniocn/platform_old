// 初始化设置
layui.config({
    base: '/static/layuiadmin/' // 静态资源所在路径
}).extend({
    // layui-admin 组件
    index: 'lib/index',

    // vendor
    dtree: '../vendor/dtree/dtree',
    treeTable: '../vendor/treeTable',
}).use(['layer'], function () {
  var $ = layui.$;

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
  } );
});
