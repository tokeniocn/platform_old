<?php


use App\Http\Controllers\Frontend\Api\Auth\LoginController;
use App\Http\Controllers\Frontend\Api\Auth\RegisterController;
use App\Http\Controllers\Frontend\Api\Auth\UserController;
use App\Http\Controllers\Frontend\Api\Auth\LogoutController;
use App\Http\Controllers\Frontend\Api\Auth\VerifyController;

/*
 * Frontend Access Controllers
 * All route names are prefixed with 'frontend.auth'.
 */
Route::group([
    'namespace' => 'Auth',
    'as' => 'auth.'
], function () {
    Route::group(['middleware' => 'guest'], function () {

        Route::post('v1/login', [LoginController::class, 'login'])->name('login'); // 密码登录
        Route::post('v1/register', [RegisterController::class, 'register'])->name('register'); // 用户注册

//
//        // Socialite Routes
//        Route::get('login/{provider}', [SocialLoginController::class, 'login'])->name('social.login');
//        Route::get('login/{provider}/callback', [SocialLoginController::class, 'login']);
//
//        // Registration Routes
//        Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
//        Route::post('register', [RegisterController::class, 'register'])->name('register.post');
//
//        // Confirm Account Routes
//        Route::get('account/confirm/{token}', [ConfirmAccountController::class, 'confirm'])->name('account.confirm');
//        Route::get('account/confirm/resend/{uuid}', [ConfirmAccountController::class, 'sendConfirmationEmail'])->name('account.confirm.resend');
//
//        // Password Reset Routes
//        Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.email');
//        Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email.post');
//
//        Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset.form');
//        Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.reset');
    });
    Route::group(['middleware' => ['auth:airlock']], function () {
        Route::post('logout', [LogoutController::class, 'logout'])->name('logout'); // 退出登录
    });

    Route::group([
        'prefix' => 'v1/auth',
        'middleware' => ['auth:airlock']
    ], function () {
        Route::get('user/info', [UserController::class, 'info'])->name('user.info'); // 登录会员信息

        Route::get('verify/email', [VerifyController::class, 'requestVerifyEmail'])->name('verify.email'); // 验证邮箱请求

        Route::get('verify/mobile', [VerifyController::class, 'requestVerifyMobile'])->name('verify.mobile'); // 修改手机号请求
        Route::post('verify/mobile', [VerifyController::class, 'verifyMobile'])->name('verify.mobile'); // 修改手机号

        Route::get('reset/password', [VerifyController::class, 'resetPassword'])->name('reset.mail'); //
        Route::post('reset/password', [VerifyController::class, 'resetPassword'])->name('reset.mail'); //

        Route::get('reset/pay_password', [VerifyController::class, 'resetPayPassword'])->name('verify.mobile'); // 修改手机号
        Route::post('reset/pay_password', [VerifyController::class, 'resetPayPassword'])->name('verify.mobile'); // 修改手机号

//        // These routes can not be hit if the password is expired
//        Route::group(['middleware' => 'password_expires'], function () {
//            // Change Password Routes
//            Route::patch('password/update', [UpdatePasswordController::class, 'update'])->name('password.update');
//        });
//
//        // Password expired routes
//        Route::get('password/expired', [PasswordExpiredController::class, 'expired'])->name('password.expired');
//        Route::patch('password/expired', [PasswordExpiredController::class, 'update'])->name('password.expired.update');
    });
});
