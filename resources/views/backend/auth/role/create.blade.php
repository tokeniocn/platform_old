@extends('backend.layouts.app')

@section('title', __('labels.backend.access.roles.management') . ' | ' . __('labels.backend.access.roles.create'))

@section('content')
    <form class="layui-form">
        <div class="layui-form-item">
            <label class="layui-form-label">角色名称</label>
            <div class="layui-input-block">
                <input class="layui-input" type="text" name="title" placeholder="请输入角色名称" />
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">角色关键字</label>
            <div class="layui-input-block">
                <input class="layui-input" type="text" name="name" placeholder="请输入角色关键字" />
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">选择权限</label>
            <div class="layui-input-block">
                <div id="toolbarDiv" style="max-height:200px; overflow: auto; padding: 15px 5px; border: 1px  solid #e6e6e6; background-color: #fff; border-radius: 2px;">
                    <ul id="LAY-auth-permission-tree" data-id="0"></ul>
                </div>

            </div>
        </div>
        <div class="layui-form-item" lay-iframe-hide>
            <div class="layui-input-block">
                <button class="layui-btn" type="submit" lay-submit lay-filter="LAY-auth-role-submit">提交</button>
            </div>
        </div>
    </form>
@endsection


@push('after-scripts')
    <script>
        layui.use(['jquery', 'dtree', 'tree', 'form', 'layer', 'treeTable'], function() {

            var $ = layui.jquery;
            var form = layui.form;
            var layer = layui.layer;
            var tree = layui.tree;

            function normalizeData(data, idStart = 0) {
                var result = [];
                for (let i = 0; i < data.length; i++) {
                    if (data[i].parent_id == idStart) {
                        data[i].title = data[i].title + ' <small title="权限标识">(' + data[i].name + ')<small>';
                        data[i].children = normalizeData(data, data[i].id);
                        data[i].spread = true;
                        data[i].checked = false;
                        result.push(data[i]);
                    }
                }
                return result;
            }

            $.get("{{ route('admin.api.auth.permissions') }}", function(data) {

                tree.render({
                    elem: '#LAY-auth-permission-tree'
                    ,data: normalizeData(data)
                    ,showCheckbox: true  //是否显示复选框
                    ,id: 'permissions'
                })
            });


            // var dtree = layui.dtree;
            /*dtree.render({
                elem: "#LAY-auth-permission-tree",
                url: "{{ route('admin.api.auth.permissions') }}",
                skin: 'layui',
                dataFormat: "list",
                dataStyle: 'layuiStyle',
                method: 'get',
                normalizeData: function(res) {
                    return {
                        msg: '',
                        code: 200,
                        data: res.map(function(data) {
                            return {
                                id: data.id,
                                parentId: data.parent_id,
                                name: data.name,
                                title: data.title,
                                sort: data.sort,
                                checkArr: [{"type": "0", "checked": "0"}],
                            }
                        }),
                    };
                },
                checkbar:true, //开启复选框: true,

                line: true, // 显示树线
                initLevel: 1,
                nodeIconArray: {"3": {"open": "dtree-icon-jian", "close": "dtree-icon-jia"}}, // 自定扩展的一级非最后一级图标，从2开始
                ficon: ["3", "8"], // 使用，3表示使用扩展的图标，7表示最后一级图标使用内置的文件图标
                menubar: true,
                menubarTips:{
                    group: ["moveDown", "moveUp", "refresh"]
                },
                formatter: {
                    title: function(data) { // 文字过滤，返回null,"",undefined之后，都不会改变原有的内容返回。
                        return data.title + ' <small title="权限标识">' + data.name + '</small>';
                    }
                },
                toolbar: true,
                scroll:"#toolbarDiv",
                // toolbarStyle: {
                //     title: "权限",
                //     area: ["50%", "400px"]
                // },
                // toolbarBtn:[
                //     [
                //         {"label": "排序", "name": "sort", "type": "text"},
                //     ], // 自定义编辑页的内容
                //     [
                //         {"label": "排序", "name": "sort", "type": "text"},
                //     ] // 自定义编辑页的内容
                // ],
                toolbarShow: [], // 默认按钮制空
                toolbarExt: [
                    {
                        toolbarId: 'testAdd', icon: 'dtree-icon-wefill', title: '自定义新增', handler: function (node, $div) {
                            layer.msg(JSON.stringify(node))
                            // 你可以在此添加一个layer.open，里面天上你需要添加的表单元素，就跟你写新增页面是一样的
                            layer.open({
                                success: function (layero, index) {
                                    form.render()
                                    form.on('submit(addNode_form)', function (data) {// 假设form的filter为addNode_form
                                        console.log(data.field)// 从form中取值，数据来源由你自己定

                                        var json = {
                                            'id': data.field.addId,
                                            'title': data.field.addNodeName,
                                            'parentId': node.nodeId
                                        }
                                        var arr = [{
                                            'id': data.field.addId,
                                            'title': data.field.addNodeName,
                                            'parentId': node.nodeId
                                        }]
                                        //DTree5.partialRefreshAdd($div); // 省略第二个参数，则会加载url
                                        //DTree5.partialRefreshAdd($div, json); // 如果是json对象，则会追加元素
                                        //DTree5.partialRefreshAdd($div, arr); //如果是json数组，则会重载节点中的全部子节点

                                        layer.close(index)
                                        return false
                                    })
                                }
                            })
                        }
                    },
                    {
                        toolbarId: 'editPermission',
                        icon: 'dtree-icon-bianji',
                        title: '编辑权限',
                        handler: function (node, $div) {
                            console.log(node);
                            layer.open({
                                type:"1",
                                content: '<div class="dtree-toolbar-tool">' +
                                    '<form class="layui-form layui-form-pane" lay-filter="dtree_editNode_form">' +
                                    '<div class="layui-form-item">' +
                                    '  <label class="layui-form-label" title="编辑权限">权限标识：</label>' +
                                    '  <div class="layui-input-block f-input-par">' +
                                    '  <input type="text" class="layui-input f-input" value="'+ node.context +'" placeholder="" lay-verify="required" name="title">' +
                                    ' </div>' +
                                    '</div>' +
                                    '<div class="layui-form-item">' +
                                    '<div class="layui-input-block" style="margin-left:0px;text-align:center;">' +
                                    '<button type="button" class="layui-btn layui-btn-normal btn-w100" lay-submit="" lay-filter="dtree_editNode_form">提交</button>' +
                                    '</div>' +
                                    '</div>' +
                                    '</form>' +
                                    '</div>',
                                success: function(layero, index){
                                    form.render();
                                    form.on("submit(dtree_editNode_form)",function(data){
                                        console.log(data.field);

                                        var json = {"id":"123123123123","title": data.field.editNodeName,"parentId": node.nodeId};

                                        var str = data.field.editNodeName;
                                        DTree5.partialRefreshEdit($div, json);
                                        layer.close(index);
                                        return false;
                                    });
                                }
                            })
                        }
                    },
                    {
                        toolbarId: 'testDel',
                        icon: 'dtree-icon-roundclose',
                        title: '自定义删除',
                        handler: function (node, $div) {
                            layer.msg(JSON.stringify(node))
                            DTree5.partialRefreshDel($div) // 这样即可删除节点
                        }
                    }
                ]
            });*/

        });
    </script>
@endpush
