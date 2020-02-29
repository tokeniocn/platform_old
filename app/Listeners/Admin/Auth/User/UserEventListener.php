<?php

namespace App\Listeners\Admin\Auth\User;

use App\Events\Admin\Auth\User\UserConfirmed;
use App\Events\Admin\Auth\User\UserCreated;
use App\Events\Admin\Auth\User\UserDeactivated;
use App\Events\Admin\Auth\User\UserDeleted;
use App\Events\Admin\Auth\User\UserPasswordChanged;
use App\Events\Admin\Auth\User\UserPermanentlyDeleted;
use App\Events\Admin\Auth\User\UserReactivated;
use App\Events\Admin\Auth\User\UserRestored;
use App\Events\Admin\Auth\User\UserSocialDeleted;
use App\Events\Admin\Auth\User\UserUnconfirmed;
use App\Events\Admin\Auth\User\UserUpdated;

/**
 * Class UserEventListener.
 */
class UserEventListener
{
    /**
     * @param $event
     */
    public function onCreated($event)
    {
        logger('User Created');
    }

    /**
     * @param $event
     */
    public function onUpdated($event)
    {
        logger('User Updated');
    }

    /**
     * @param $event
     */
    public function onDeleted($event)
    {
        logger('User Deleted');
    }

    /**
     * @param $event
     */
    public function onConfirmed($event)
    {
        logger('User Confirmed');
    }

    /**
     * @param $event
     */
    public function onUnconfirmed($event)
    {
        logger('User Unconfirmed');
    }

    /**
     * @param $event
     */
    public function onPasswordChanged($event)
    {
        logger('User Password Changed');
    }

    /**
     * @param $event
     */
    public function onDeactivated($event)
    {
        logger('User Deactivated');
    }

    /**
     * @param $event
     */
    public function onReactivated($event)
    {
        logger('User Reactivated');
    }

    /**
     * @param $event
     */
    public function onSocialDeleted($event)
    {
        logger('User Social Deleted');
    }

    /**
     * @param $event
     */
    public function onPermanentlyDeleted($event)
    {
        logger('User Permanently Deleted');
    }

    /**
     * @param $event
     */
    public function onRestored($event)
    {
        logger('User Restored');
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param \Illuminate\Events\Dispatcher $events
     */
    public function subscribe($events)
    {
        $events->listen(
            UserCreated::class,
            'App\Listeners\Admin\Auth\User\UserEventListener@onCreated'
        );

        $events->listen(
            UserUpdated::class,
            'App\Listeners\Admin\Auth\User\UserEventListener@onUpdated'
        );

        $events->listen(
            UserDeleted::class,
            'App\Listeners\Admin\Auth\User\UserEventListener@onDeleted'
        );

        $events->listen(
            UserConfirmed::class,
            'App\Listeners\Admin\Auth\User\UserEventListener@onConfirmed'
        );

        $events->listen(
            UserUnconfirmed::class,
            'App\Listeners\Admin\Auth\User\UserEventListener@onUnconfirmed'
        );

        $events->listen(
            UserPasswordChanged::class,
            'App\Listeners\Admin\Auth\User\UserEventListener@onPasswordChanged'
        );

        $events->listen(
            UserDeactivated::class,
            'App\Listeners\Admin\Auth\User\UserEventListener@onDeactivated'
        );

        $events->listen(
            UserReactivated::class,
            'App\Listeners\Admin\Auth\User\UserEventListener@onReactivated'
        );

        $events->listen(
            UserSocialDeleted::class,
            'App\Listeners\Admin\Auth\User\UserEventListener@onSocialDeleted'
        );

        $events->listen(
            UserPermanentlyDeleted::class,
            'App\Listeners\Admin\Auth\User\UserEventListener@onPermanentlyDeleted'
        );

        $events->listen(
            UserRestored::class,
            'App\Listeners\Admin\Auth\User\UserEventListener@onRestored'
        );
    }
}
