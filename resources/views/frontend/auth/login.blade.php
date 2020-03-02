@extends('frontend.layouts.app')

@section('content')
    <div class="row justify-content-center align-items-center">
        <div class="col col-sm-8 align-self-center">
            <div class="card">
                <div class="card-header">
                    <strong>
                       登录
                    </strong>
                </div><!--card-header-->

                <div class="card-body">
                    {{ html()->form('POST', route('frontend.auth.login.post'))->open() }}
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    {{ html()->label('邮箱')->for('email') }}

                                    {{ html()->email('email')
                                        ->class('form-control')
                                        ->placeholder('请输入邮箱地址')
                                        ->attribute('maxlength', 191)
                                        ->required() }}
                                </div><!--form-group-->
                            </div><!--col-->
                        </div><!--row-->

                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    {{ html()->label('密码')->for('password') }}

                                    {{ html()->password('password')
                                        ->class('form-control')
                                        ->placeholder('请输入密码')
                                        ->required() }}
                                </div><!--form-group-->
                            </div><!--col-->
                        </div><!--row-->

                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    {{ html()->label('验证码')->for('captcha') }}

                                    <div class="row">
                                        <div class="col-sm-8">
                                            {{ html()->password('captcha')
                                                            ->class('form-control')
                                                            ->placeholder('请输入验证码')
                                                            ->required() }}
                                        </div>
                                        <div class="col-auto">
                                            <img src="{{ captcha_src() }}">
                                        </div>
                                    </div>

                                </div><!--form-group-->
                            </div><!--col-->
                        </div><!--row-->

                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col">
                                            <div class="checkbox">
                                                {{ html()->label(html()->checkbox('remember', true, 1) . ' 记住我')->for('remember') }}
                                            </div>
                                        </div>
                                        <div class="col text-right">
                                            <div class="checkbox">
                                                <a href="{{ route('frontend.auth.password.reset') }}">忘记密码?</a>
                                            </div>
                                        </div>
                                    </div>

                                </div><!--form-group-->
                            </div><!--col-->
                        </div><!--row-->

                        <div class="row">
                            <div class="col">
                                <div class="form-group clearfix">
                                    {{ form_submit('登录', 'btn btn-success btn-block') }}

                                </div><!--form-group-->
                            </div><!--col-->
                        </div><!--row-->

                    {{ html()->form()->close() }}

                    <div class="row">
                        <div class="col">
                            <div class="text-center">
                                @include('frontend.auth.includes.socialite')
                            </div>
                        </div><!--col-->
                    </div><!--row-->
                </div><!--card body-->
            </div><!--card-->
        </div><!-- col-md-8 -->
    </div><!-- row -->
@endsection

@push('after-scripts')

@endpush
