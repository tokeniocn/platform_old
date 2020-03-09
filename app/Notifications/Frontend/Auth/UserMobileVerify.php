<?php

namespace App\Notifications\Frontend\Auth;

use App\Models\Auth\UserVerify;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Leonis\Notifications\EasySms\Channels\EasySmsChannel;

class UserMobileVerify extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @var UserVerify
     */
    protected $userVerify;

    /**
     * UserEmailVerify constructor.
     *
     * @param string $email
     * @param string $token
     */
    public function __construct(UserVerify $userVerify)
    {
        $this->userVerify = $userVerify;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function via($notifiable)
    {
        return [EasySmsChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toEasySms($notifiable)
    {
        return (new MailMessage())
            ->subject('邮件确认')
            ->line('请点击下面按钮完成邮箱确认')
            ->action('验证邮箱', route('frontend.auth.email.verify', ['token' => $this->userVerify->token]));
    }
}
