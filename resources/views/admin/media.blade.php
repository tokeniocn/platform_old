@extends('admin.layouts.app')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header">
            <button type="button" class="layui-btn" id="upload">
                <i class="layui-icon">&#xe67c;</i>上传图片
            </button>
            <button type="button" class="layui-btn" id="test1">
                <i class="layui-icon">&#xe67c;</i>添加目录
            </button>
            <button type="button" class="layui-btn" id="test1">
                <i class="layui-icon">&#xe67c;</i>刷新
            </button>
        </div>
        <div class="layui-card-body">
            <div class="layui-row">
                <div class="layui-col-xs6 layui-col-sm6 layui-col-md4">
                    移动：6/12 | 平板：6/12 | 桌面：4/12
                </div>
                <div class="layui-col-xs6 layui-col-sm6 layui-col-md4">
                    移动：6/12 | 平板：6/12 | 桌面：4/12
                </div>
                <div class="layui-col-xs4 layui-col-sm12 layui-col-md4">
                    移动：4/12 | 平板：12/12 | 桌面：4/12
                </div>
                <div class="layui-col-xs4 layui-col-sm7 layui-col-md8">
                    移动：4/12 | 平板：7/12 | 桌面：8/12
                </div>
                <div class="layui-col-xs4 layui-col-sm5 layui-col-md4">
                    移动：4/12 | 平板：5/12 | 桌面：4/12
                </div>
            </div>
        </div>
    </div>

@endsection

@push('after-scripts')
    <script>
        layui.use(['upload', 'util'], function () {

            var $ = layui.$,
                util = layui.util,
                upload = layui.upload;

            //执行实例
            var uploadInst = upload.render({
                elem: '#upload' //绑定元素
                ,url: '{{ route('admin.api.media.upload') }}' //上传接口
                ,done: function(res){
                    //上传完毕回调
                }
                ,error: function(){
                    //请求异常回调
                }
            });

            $.get('{{ route('admin.api.media.index') }}');
        })
    </script>
@endpush
