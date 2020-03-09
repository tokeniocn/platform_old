<?php

namespace App\Http\Controllers\Frontend\Api\Auth;

use Str;
use Carbon\Carbon;
use App\Models\Auth\User;
use App\Models\Auth\UserVerify;
use App\Http\Controllers\Controller;
use App\Repositories\Frontend\Auth\UserRepository;
use App\Notifications\Frontend\Auth\UserEmailVerify;
use App\Http\Requests\Frontend\Auth\VerifyEmailRequest;
use App\Http\Requests\Frontend\Auth\VerifyMobileRequest;
use Illuminate\Validation\ValidationException;

class VerifyController extends Controller
{
    /**
     * @var UserRepository
     */
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function requestVerifyEmail(VerifyEmailRequest $request)
    {
        /** @var User $user */
        $user = $request->user();

        $email = $request->email ?: $user->email;

        if ($email == $user->email && $user->isEmailVerified()) {
            ValidationException::withMessages([
                'email' => 'Current email is already verified.'
            ]);
        }

        if (empty($email)) {
            ValidationException::withMessages([
                'email' => 'Email must be set.'
            ]);
        }

        /** @var UserVerify $verify */
        $verify = UserVerify::create([
            'uid' => $user->id,
            'key' => $email,
            'type' => UserVerify::TYPE_VERIFY_EMAIL,
            'token' => Str::uuid(),
            'expired_at' => Carbon::now()->addSeconds(config('user.verify.expires.email', 3600)),
        ]);

        $verify->makeOtherExpired();

        $user->sendEmailVerify($verify);

        return [];
    }

    public function requestVerifyMobile(VerifyMobileRequest $request)
    {
        /** @var User $user */
        $user = $request->user();

        $mobile = $request->mobile ?: $user->mobile;

        if ($mobile == $user->mobile && $user->isMobileVerified()) {
            ValidationException::withMessages([
                'mobile' => 'Current mobile is already verified.'
            ]);
        }

        if (empty($mobile)) {
            ValidationException::withMessages([
                'mobile' => 'Mobile must be set.'
            ]);
        }

        /** @var UserVerify $verify */
        $verify = UserVerify::create([
            'uid' => $user->id,
            'key' => $mobile,
            'type' => UserVerify::TYPE_VERIFY_MOBILE,
            'token' => Str::uuid(),
            'expired_at' => Carbon::now()->addSeconds(config('user.verify.expires.mobile', 300)),
        ]);

        $verify->makeOtherExpired();

        $user->sendMobileVerify($verify);

        return [];
    }

    public function verifyMobile()
    {
        
    }

    public function requestResetPassword()
    {

    }

    public function resetPassword()
    {
        
    }

    public function requestResetPayPassword()
    {

    }

    public function resetPayPassword()
    {
        
    }
}
