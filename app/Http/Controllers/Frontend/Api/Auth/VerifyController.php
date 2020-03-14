<?php

namespace App\Http\Controllers\Frontend\Api\Auth;

use App\Models\Auth\User;
use App\Models\Auth\UserVerify;
use App\Http\Controllers\Controller;
use App\Events\Frontend\Auth\UserMobileVerified;
use App\Http\Requests\Frontend\Auth\ResetMobileRequest;

class VerifyController extends Controller
{

    public function verifyMobile(ResetMobileRequest $request)
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
}
