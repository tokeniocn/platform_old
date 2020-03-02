@extends('frontend.layouts.app')

@section('content')
    <div class="row justify-content-center align-items-center">
        <div class="col col-sm-8 align-self-center">
            <div class="card">
                <div class="card-header">
                    <strong>
                        注册
                    </strong>
                </div><!--card-header-->

                <div class="card-body">
                    {{ html()->form('POST', route('frontend.auth.register.post'))->open() }}
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    {{ html()->label('用户名')->for('username') }}

                                    {{ html()->email('username')
                                        ->class('form-control')
                                        ->placeholder('请输入用户名')
                                        ->attribute('maxlength', 191)
                                        ->required() }}
                                </div><!--row-->
                            </div><!--col-->
                        </div><!--row-->

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
                                    {{ html()->label('确认密码')->for('password_confirmation') }}

                                    {{ html()->password('password_confirmation')
                                        ->class('form-control')
                                        ->placeholder('请输入确认密码')
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
                                <div class="form-group mb-0 clearfix">
                                    {{ form_submit('注册', 'btn btn-success btn-block') }}
                                </div><!--form-group-->
                            </div><!--col-->
                        </div><!--row-->
                    {{ html()->form()->close() }}

                    <div class="row">
                        <div class="col">
                            <div class="text-center">
                                @include('frontend.auth.includes.socialite')
                            </div>
                        </div><!--/ .col -->
                    </div><!-- / .row -->
                </div><!-- card-body -->
            </div><!-- card -->
        </div><!-- col-md-8 -->
    </div><!-- row -->
@endsection

@push('after-scripts')

@endpush
