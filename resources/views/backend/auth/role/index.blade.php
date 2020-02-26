@extends('backend.layouts.app')

@section('content')
    <div class="layui-card">
        <div class="layui-card-body">
            <table id="LAY-user-back-role" lay-filter="LAY-user-back-role"></table>
            <script type="text/html" id="buttonTpl">
                @{{#  if(d.check == true){ }}
                <button class="layui-btn layui-btn-xs">已审核</button>
                @{{#  } else { }}
                <button class="layui-btn layui-btn-primary layui-btn-xs">未审核</button>
                @{{#  } }}
            </script>
            <script type="text/html" id="table-useradmin-admin">
                <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="edit"><i
                        class="layui-icon layui-icon-edit"></i>编辑</a>
                <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del"><i
                        class="layui-icon layui-icon-delete"></i>删除</a>
            </script>
        </div>
    </div>
@endsection

@push('after-scripts')
    <script type="text/html" id="tableToolbar">
        <div class="layui-btn-container">
            <button class="layui-btn layuiadmin-btn-role" lay-demo="add">添加角色</button>
        </div>
    </script>
    <script>
        layui.use(['form', 'table', 'util'], function () {

            var $ = layui.$
                , util = layui.util
                , form = layui.form
                , table = layui.table
                , iframeEvent = layui.iframeEvent

            table.render({
                elem: '#LAY-user-back-role',
                toolbar: '#tableToolbar',
                url: '{{ route('admin.api.auth.roles') }}',
                parseData: function (res) { //res 即为原始返回的数据
                    return {
                        'code': res.message ? 400 : 0, //解析接口状态
                        'msg': res.message || '操作失败', //解析提示文本
                        'count': res.total || 0, //解析数据长度
                        'data': res.data || [] //解析数据列表
                    };
                },
                cols: [[{
                    type: 'checkbox',
                    fixed: 'left'
                }, {
                    field: 'id',
                    width: 80,
                    title: 'ID',
                    sort: !0
                }, {
                    field: 'name',
                    title: '关键字'
                }, {
                    field: 'title',
                    title: '角色名'
                }, {
                    title: '操作',
                    width: 150,
                    align: 'center',
                    fixed: 'right',
                    toolbar: '#table-useradmin-admin'
                }]],
                text: '对不起，加载出现异常！',
                page: true
            })

            //搜索角色
            form.on('select(LAY-user-adminrole-type)', function (data) {
                //执行重载
                table.reload('LAY-user-back-role', {
                    where: {
                        role: data.value
                    }
                })
            })

            //事件
            var active = {
                batchdel: function () {
                    var checkStatus = table.checkStatus('LAY-user-back-role')
                        , checkData = checkStatus.data //得到选中的数据

                    if (checkData.length === 0) {
                        return layer.msg('请选择数据')
                    }

                    layer.confirm('确定删除吗？', function (index) {

                        //执行 Ajax 后重载
                        /*
                        admin.req({
                          url: 'xxx'
                          //,……
                        });
                        */
                        table.reload('LAY-user-back-role')
                        layer.msg('已删除')
                    })
                },
                add: function () {
                    layer.open({
                        type: 2
                        , title: '添加新角色'
                        , content: '{{ route('admin.auth.role.create') }}'
                        , area: ['500px', '480px']
                        , btn: ['确定', '取消']
                        , yes: function (index, layero) {


                            iframeEvent(index).trigger('submit(LAY-role-submit)', function (data) {
                                var field = data.field //获取提交的字段

                                //提交 Ajax 成功后，静态更新表格中的数据
                                //$.ajax({});
                                table.reload('LAY-user-back-role')
                                layer.close(index) //关闭弹层
                            });

                            var iframeWindow = window['layui-layer-iframe' + index]
                                , submit = layero.find('iframe').contents().find('#LAY-user-role-submit')

                            //监听提交
                            iframeWindow.layui.form.on('submit(LAY-user-role-submit)', function (data) {
                                var field = data.field //获取提交的字段

                                //提交 Ajax 成功后，静态更新表格中的数据
                                //$.ajax({});
                                table.reload('LAY-user-back-role')
                                layer.close(index) //关闭弹层
                            })

                            submit.trigger('click')
                        }
                    })
                }
            }
            $('.layui-btn.layuiadmin-btn-role').on('click', function () {
                var type = $(this).data('type')
                active[type] ? active[type].call(this) : ''
            })

            const events = {
                add: function (othis) {
                    layer.open({
                        type: 2
                        , title: '添加新角色'
                        , content: '{{ route('admin.auth.role.create') }}'
                        , area: ['500px', '480px']
                        , btn: ['确定', '取消']
                        , yes: function (index, layero) {
                            var iframeWindow = window['layui-layer-iframe' + index]
                                , submit = layero.find('iframe').contents().find('#LAY-auth-role-submit')

                            //监听提交
                            iframeWindow.layui.form.on('submit(LAY-auth-role-submit)', function (data) {
                                var field = data.field //获取提交的字段

                                //提交 Ajax 成功后，静态更新表格中的数据
                                //$.ajax({});
                                table.reload('LAY-user-back-role')
                                layer.close(index) //关闭弹层
                            })

                            submit.trigger('click')
                        }
                    })
                }
            };
            util.event('lay-demo', events);
        })
    </script>
@endpush

