<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>@yield('title', app_name())</title>
    <meta content="webkit" name="renderer">
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport">
    {{ style('static/layuiadmin/layui/css/layui.css') }}
    {{ style('static/layuiadmin/style/admin.css') }}
</head>
<body>

<div class="layadmin-user-login layadmin-user-display-show" id="LAY-user-login" style="display: none;">

    <div class="layadmin-user-login-main">
        <div class="layadmin-user-login-box layadmin-user-login-header">
            <h2>{{ app_name() }}</h2>
            <p>后台管理系统</p>
        </div>
        <div class="layadmin-user-login-box layadmin-user-login-body layui-form">
            <div class="layui-form-item">
                <label class="layadmin-user-login-icon layui-icon layui-icon-username"
                       for="LAY-user-login-username"></label>
                <input class="layui-input" id="LAY-user-login-username" lay-verify="required" name="username"
                       placeholder="用户名"
                       type="text">
            </div>
            <div class="layui-form-item">
                <label class="layadmin-user-login-icon layui-icon layui-icon-password"
                       for="LAY-user-login-password"></label>
                <input class="layui-input" id="LAY-user-login-password" lay-verify="required" name="password"
                       placeholder="密码" type="password">
            </div>
            <div class="layui-form-item">
                <div class="layui-row">
                    <div class="layui-col-xs7">
                        <label class="layadmin-user-login-icon layui-icon layui-icon-vercode"
                               for="LAY-user-login-vercode"></label>
                        <input class="layui-input" id="LAY-user-login-vercode" lay-verify="required" name="vercode"
                               placeholder="图形验证码" type="text">
                    </div>
                    <div class="layui-col-xs5">
                        <div style="margin-left: 10px;">
                            <img class="layadmin-user-login-codeimg" id="LAY-user-get-vercode"
                                 src="xxx">
                        </div>
                    </div>
                </div>
            </div>
            <div class="layui-form-item">
                <button class="layui-btn layui-btn-fluid" lay-filter="LAY-user-login-submit" lay-submit>登 入</button>
            </div>
        </div>
    </div>

</div>

{!! script('static/layuiadmin/layui/layui.js') !!}
{!! script('static/admin/js/admin.js') !!}
<script>
    layui.use(['index', 'user'], function () {

        var $ = layui.$
            , $body = $('body')
            , setter = layui.setter
            , admin = layui.admin
            , form = layui.form
            , router = layui.router()
        var captchaUrl = '{:url(\'/admin/captcha\', [], false, true)}'
        var $captcha = $('#LAY-user-get-vercode')

        form.render()

        //提交
        form.on('submit(LAY-user-login-submit)', function (obj) {

            $.post('{:url(\'/admin/login\', [], false, true)}', obj.field, function (res) {
                if (res.code == 200) { // 成功跳转
                    location.href = '{:url(\'/admin\', [], false, true)}'
                } else {
                    updateCaptcha()
                    layer.msg(res.msg || '登录失败', {
                        offset: '15px'
                        , icon: 2
                        , time: 1000
                    })
                }
            })

        })

        $body.on('click', '#LAY-user-get-vercode', updateCaptcha)

        function updateCaptcha () {
            $captcha.attr('src', captchaUrl + '?t=' + new Date().getTime())
        }
    })
</script>
</body>
</html>
