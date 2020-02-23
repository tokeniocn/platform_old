<!DOCTYPE html>
@langrtl
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
@else
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@endlangrtl
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', app_name())</title>
    <meta name="description" content="@yield('meta_description', 'TokenIO')">
    @yield('meta')

    @stack('before-styles')
    {{ style('static/layuiadmin/layui/css/layui.css') }}
    {{ style('static/layuiadmin/style/admin.css') }}
    @stack('after-styles')
</head>

<body>

    <div class="layui-fluid">
        @include('includes.partials.messages')
        @yield('content')
    </div><!--layui-fluid-->

    <!-- Scripts -->
    @stack('before-scripts')
    {!! script('static/layuiadmin/layui/layui.js') !!}
    <script>
        layui.config({
            base: 'static/layuiadmin/' //静态资源所在路径
        }).extend({
            index: 'lib/index' //主入口模块
        }).use(['index'])
    </script>
    @stack('after-scripts')
</body>
</html>
