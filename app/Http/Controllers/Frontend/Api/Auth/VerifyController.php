<?php

namespace App\Http\Controllers\Frontend\Api\Auth;

use Carbon\Carbon;
use Str;
use App\Models\Auth\UserVerify;
use App\Http\Controllers\Controller;
use App\Repositories\Frontend\Auth\UserRepository;
use App\Notifications\Frontend\Auth\UserEmailVerify;
use App\Http\Requests\Frontend\Auth\VerifyMailRequest;
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

    public function verifyEmail(VerifyMailRequest $request)
    {
        $user = $request->user();

        $email = $request->email ?: $user->email;

        if ($email == $user->email) {
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

        $user->notify(new UserEmailVerify($verify));

        return [];

    }

    public function verifyMail(VerifyMailRequest $request)
    {
        
    }

    public function requestVerifyMobile()
    {

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
