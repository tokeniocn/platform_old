<?php

namespace App\Models\Auth\Traits\Method;

use App\Models\Auth\UserVerify;
use App\Notifications\Frontend\Auth\UserEmailVerify;
use App\Notifications\Frontend\Auth\UserMobileVerify;

trait UserNotificationMethod
{
    /**
     * @var string|int
     */
    public $notificationMobile;
    /**
     * @var string|int
     */
    public $notificationMail;

    public function sendEmailVerify(UserVerify $verify)
    {
        $this->notify(new UserEmailVerify($verify));
    }

    public function sendMobileVerify(UserVerify $verify)
    {
        $this->notify(new UserMobileVerify($verify));
    }

    public function withNotificationMobile($mobile)
    {
        $this->notificationMobile = $mobile;

        return $this;
    }

    public function routeNotificationForEasySms()
    {
        return $this->notificationMobile ?: $this->mobile;
    }

    public function withNotificationEmail($mobile)
    {
        $this->notificationMobile = $mobile;

        return $this;
    }

    public function routeNotificationForMail()
    {
        return $this->notificationMail ?: $this->email;
    }
}
