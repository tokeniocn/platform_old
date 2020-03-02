<?php

namespace App\Http\Controllers\Frontend\Api\Auth;

use App\Events\Frontend\Auth\UserLoggedIn;
use App\Events\Frontend\Auth\UserLoggedOut;
use App\Exceptions\GeneralException;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use LangleyFoxall\LaravelNISTPasswordRules\PasswordRules;

/**
 * @OA\Tag(
 *     name="Auth",
 *     description="登录",
 * )
 */
class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return config('access.users.username');
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateLogin(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => PasswordRules::login(),
            'captcha' => 'required|captcha'
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/login",
     *     operationId="login",
     *     tags={"Auth"},
     *     summary="用户密码登录",
     *     description="提交账号密码登录",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="username",
     *                     description="用户名",
     *                     type="string",
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     description="密码",
     *                     type="string",
     *                 ),
     *                 @OA\Property(
     *                     property="captcha",
     *                     description="验证码",
     *                     type="string",
     *                 ),
     *             ),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="成功登录"
     *     ),
     * )
     */
    protected function authenticated(Request $request, $user)
    {
        if (! $user->isActive()) {
            auth()->logout();

            throw new GeneralException(__('exceptions.frontend.auth.deactivated'));
        }

        event(new UserLoggedIn($user));

        if (config('access.users.single_login')) {
            auth()->logoutOtherDevices($request->password);
        }

    }

    /**
     * Log the user out of the application.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        // Fire event, Log out user, Redirect
        event(new UserLoggedOut($request->user()));

        // Laravel specific logic
        $this->guard()->logout();
        $request->session()->invalidate();

        return [];
    }
}
