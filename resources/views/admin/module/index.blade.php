@extends('admin.layouts.app')

@section('content')
    <div class="layui-card">
        <div class="layui-card-body">
            <table id="LAY-user-back-role" lay-filter="LAY-user-back-role"></table>
            <script type="text/html" id="table-useradmin-admin">
                <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del"><i
                        class="layui-icon layui-icon-delete"></i>禁用</a>
            </script>
        </div>
    </div>
@endsection

@push('after-scripts')
    <script>
        layui.use(['form', 'table', 'util'], function () {

            var $ = layui.$
                , util = layui.util
                , form = layui.form
                , table = layui.table;

            var events = {
                del: function (data) {
                    layer.confirm('确定删除吗？', function () {
                        var url = '{{ route('admin.api.auth.role.destroy', ['role' => '!role!']) }}'.replace('!role!', data.name);
                        $.ajax({
                            url: url,
                            type: 'delete',
                            success: function() {
                                table.reload('LAY-user-back-role')
                                layer.msg('删除成功', {
                                    offset: '15px',
                                });
                            }
                        });
                    });
                },
                add: function () {
                    events.edit();
                },
                edit: function(data) {
                    var url = data ? '{{ route('admin.auth.role.edit', ['role' => '!role!']) }}'.replace('!role!', data.name) :
                        '{{ route('admin.auth.role.create') }}';
                    layer.open({
                        type: 2
                        , title: '添加新角色'
                        , content: url
                        , area: ['500px', '480px']
                        , btn: ['确定', '取消']
                        , yes: function (index, layero) {
                            var iframeWindow = window['layui-layer-iframe' + index]
                            submit = layero.find('iframe').contents().find('#LAY-auth-role-submit');

                            //监听提交
                            iframeWindow.layui.onevent('submitted', 'form', function (data) {
                                console.log(data);
                                table.reload('LAY-user-back-role')
                                layer.close(index) //关闭弹层
                            })

                            submit.trigger('click')
                        }
                    })
                }
            };

            table.render({
                elem: '#LAY-user-back-role',
                url: '{{ route('admin.api.module.modules') }}',
                parseData: function (res) { //res 即为原始返回的数据
                    return {
                        'code': 0, //解析接口状态
                        'msg': '', //解析提示文本
                        'count': res.length, //解析数据长度
                        'data': res || [] //解析数据列表
                    };
                },
                cols: [[{
                    field: 'name',
                    title: '模块名',
                }, {
                    field: 'alias',
                    title: '关键字'
                }, {
                    field: 'description',
                    title: '描述'
                }, {
                    title: '操作',
                    width: 150,
                    align: 'center',
                    fixed: 'right',
                    toolbar: '#table-useradmin-admin'
                }]],
                text: '对不起，加载出现异常！',
            });
            table.on("tool(LAY-user-back-role)", function(e) {
                if (events[e.event]) {
                    events[e.event].call(this, e.data);
                }
            });
            util.event('lay-demo', events);
        })
    </script>
@endpush

