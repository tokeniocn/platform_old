<?php

namespace App\Models\Auth\Traits\Method;

use App\Models\Auth\UserVerify;
use App\Notifications\Frontend\Auth\UserEmailVerify;
use App\Notifications\Frontend\Auth\UserMobileVerify;

trait UserNotificationMethod
{
    public function sendEmailVerify(UserVerify $verify)
    {
        $this->notify(new UserEmailVerify($verify));
    }

    public function sendMobileVerify(UserVerify $verify)
    {
        $this->notify(new UserMobileVerify($verify));
    }
}
