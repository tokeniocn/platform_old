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
  if (parent == window) {
    $('[lay-iframe-hide]').show();
  }

});
