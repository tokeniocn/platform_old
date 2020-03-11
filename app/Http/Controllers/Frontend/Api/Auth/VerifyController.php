<?php

namespace App\Http\Controllers\Frontend\Api\Auth;

use App\Events\Frontend\Auth\UserMobileVerified;
use Str;
use Carbon\Carbon;
use App\Models\Auth\User;
use App\Models\Auth\UserVerify;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Auth\VerifyEmailRequest;
use App\Http\Requests\Frontend\Auth\VerifyMobileRequest;
use Illuminate\Validation\ValidationException;

class VerifyController extends Controller
{
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
            'user_id' => $user->id,
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
            'user_id' => $user->id,
            'key' => $mobile,
            'type' => UserVerify::TYPE_VERIFY_MOBILE,
            'token' => random_int(100000, 999999),
            'expired_at' => Carbon::now()->addSeconds(config('user.verify.expires.mobile', 300)),
        ]);

        $verify->makeOtherExpired();

        $user->sendMobileVerify($verify);

        return [];
    }

    public function verifyMobile(VerifyMobileRequest $request)
    {
        /** @var User $user */
        $user = $request->user();

        /** @var UserVerify $verify */
        $verify = UserVerify::where('user_id', $user->id)
            ->where('token', $request->code)
            ->where('type', UserVerify::TYPE_VERIFY_MOBILE)
            ->notExpired()
            ->with(['user'])
            ->firstOrFail();

        $verify->setExpired()
               ->save();

        $verify->user
            ->setMobileVerified($verify->key)
            ->save();

        event(new UserMobileVerified($verify->user));

        return [];
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
