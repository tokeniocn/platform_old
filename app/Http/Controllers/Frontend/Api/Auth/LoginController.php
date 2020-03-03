<?php

namespace App\Http\Controllers\Frontend\Api\Auth;

use Str;
use App\Events\Frontend\Auth\UserLoggedIn;
use App\Events\Frontend\Auth\UserLoggedOut;
use App\Http\Controllers\Controller;
use Illuminate\Auth\TokenGuard;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Validation\ValidationException;
use LangleyFoxall\LaravelNISTPasswordRules\PasswordRules;

/**
 * @OA\Tag(
 *     name="Auth",
 *     description="登录",
 * )
 */
class LoginController extends Controller
{
    use ThrottlesLogins;

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'username';
    }

    public function guard()
    {
        return Auth::guard('api');
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        return $request->only($this->username(), 'password');
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
        $rules = [
            'username' => 'required|string',
            'password' => PasswordRules::login(),
        ];

        if (!config('app.debug')) {
            $rules['captcha'] = 'required|captcha_api:captcha';
        }

        $request->validate($rules);
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        $credentials = $this->credentials($request);

        $guard = $this->guard();

        /** @var TokenGuard $provider */
        $provider = $guard->getProvider();

        $user = $provider->retrieveByCredentials($credentials);

        $validated = ! is_null($user) && $provider->validateCredentials($user, $credentials);

        if ($validated) {

            $remember = $request->filled('remember');

            if ($remember) {
                if (empty($user->getRememberToken())) {
                    $user->setRememberToken($token = Str::random(60));

                    $provider->updateRememberToken($user, $token);
                }
            }

            $guard->setUser($user);

            return true;
        }

        return false;
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
     *                     description="图片验证码",
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

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {

            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Redirect the user after determining they are locked out.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function sendLockoutResponse(Request $request)
    {
        $seconds = $this->limiter()->availableIn(
            $this->throttleKey($request)
        );

        throw ValidationException::withMessages([
            $this->username() => [Lang::get('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ])],
        ])->status(Response::HTTP_TOO_MANY_REQUESTS);
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function sendLoginResponse(Request $request)
    {
        $user = $this->guard()->user();

//        if (! $user->isActive()) {
//            auth()->logout();
//
//            throw new GeneralException(__('exceptions.frontend.auth.deactivated'));
//        }

        event(new UserLoggedIn($user));

        $this->clearLoginAttempts($request);

        $token = $user->createToken($this->username());

        return ['access_token' => $token->plainTextToken];;
    }

    /**
     * Get the failed login response instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            $this->username() => [trans('auth.failed')],
        ]);
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

        return [];
    }


}
