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
                <div id="list"></div>
            </div>
        </div>
    </div>

@endsection

@push('after-scripts')
    <script>
        layui.use(['upload', 'table', 'util'], function () {
            var $ = layui.$,
                table = layui.table,
                upload = layui.upload,
                util = layui.util
            var mm = {
                defaultOptions: {
                    uploadElem: '#upload',
                    uploadUrl: '',
                    listElem: '#list',
                    listUrl: '',
                    iconPrefixUrl: '/static/img/file-types',
                    iconTypes: [
                        'ai',
                        'apk',
                        'bt',
                        'cad',
                        'code',
                        'dir',
                        'doc',
                        'eps',
                        'exe',
                        'fla',
                        'fonts',
                        'ipa',
                        'keynote',
                        'links',
                        'misc',
                        'mm',
                        'mmap',
                        'audio',
                        'mp4',
                        'number',
                        'pages',
                        'pdf',
                        'ppt',
                        'ps',
                        'rar',
                        'document',
                        'visio',
                        'web',
                        'xls',
                        'xmind',
                        'archive'
                    ]
                }
            }

            function MediaManager (options) {
                this.options = options

                this.options.uploadElem = $(this.options.uploadElem);
                this.options.listElem = $(this.options.listElem);

                this.initUpload()
                this.initList()
            }

            MediaManager.prototype.initUpload = function () {
                upload.render({
                    elem: this.options.uploadElem, //绑定元素
                    url: this.options.uploadUrl, //上传接口
                    done: function (res) {
                        //上传完毕回调
                    },
                    error: function () {
                        //请求异常回调
                    }
                })
            }
            MediaManager.prototype.initList = function () {
                this.requestData();
            }

            MediaManager.prototype.requestData = function () {
                var _this = this
                $.ajax({
                    type: 'get',
                    url: this.options.listUrl,
                    contentType: 'application/json',
                    async: false,
                    dataType: 'json',
                    headers: {},
                    success: function (res) {
                        _this.renderData(res.data)
                    },
                    error: function (e, m) {}
                })
            }

            MediaManager.prototype.renderData = function (data) {
                var _this = this
                //渲染数据
                var content = ''
                layui.each(data, function (index, file) {
                    var iconPrefixUrl = _this.options.iconPrefixUrl
                    var list = '<li>'
                    switch (file.aggregate_type) {
                        case 'image':
                            list += `<img src="${file.url}" />`
                            break;
                        default:
                            if (_this.options.iconTypes[file.aggregate_type]) {
                                list += `<img src="${iconPrefixUrl}/${file.aggregate_type}.png" />`
                            } else {
                                list += `<img src="${iconPrefixUrl}/nopic.jpg" />`
                            }

                    }
                    list += '</li>'

                    content += list;
                });

                this.options.listElem.html(content);
            }

            mm.render = function (options) {
                return new MediaManager({ ...this.defaultOptions, ...options })
            }

            var mediaManager = mm

            mediaManager.render({
                uploadUrl: '{{ route('admin.api.media.upload') }}',
                listUrl: '{{ route('admin.api.media.index') }}',
            })
        })
    </script>
@endpush
