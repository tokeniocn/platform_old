layui.define(['tree'], function (exports) {
  var $ = layui.$
  var tree = layui.tree

  exports('system/menu', {
    render: function (config) {
      $.get(config.url).then(function (data) {
        tree.render({
          elem: config.elem,
          data: data,
          edit: ['add', 'update', 'del'], //操作节点的图标
          operate: function (obj) {
            var type = obj.type; //得到操作类型：add、edit、del
            var data = obj.data; //得到当前节点的数据

            if(type === 'add'){ //增加节点
              //返回 key 值
              return false;
            } else if(type === 'update'){ //修改节点
              console.log(elem.find('.layui-tree-txt').html()); //得到修改后的内容
            } else if(type === 'del'){ //删除节点

            };
          }
        })
      })
    }
  })
})
