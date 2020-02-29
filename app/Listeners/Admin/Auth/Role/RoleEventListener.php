<?php

namespace App\Listeners\Admin\Auth\Role;

use App\Events\Admin\Auth\Role\RoleCreated;
use App\Events\Admin\Auth\Role\RoleDeleted;
use App\Events\Admin\Auth\Role\RoleUpdated;

/**
 * Class RoleEventListener.
 */
class RoleEventListener
{
    /**
     * @param $event
     */
    public function onCreated($event)
    {
        logger('Role Created');
    }

    /**
     * @param $event
     */
    public function onUpdated($event)
    {
        logger('Role Updated');
    }

    /**
     * @param $event
     */
    public function onDeleted($event)
    {
        logger('Role Deleted');
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param \Illuminate\Events\Dispatcher $events
     */
    public function subscribe($events)
    {
        $events->listen(
            RoleCreated::class,
            'App\Listeners\Admin\Auth\Role\RoleEventListener@onCreated'
        );

        $events->listen(
            RoleUpdated::class,
            'App\Listeners\Admin\Auth\Role\RoleEventListener@onUpdated'
        );

        $events->listen(
            RoleDeleted::class,
            'App\Listeners\Admin\Auth\Role\RoleEventListener@onDeleted'
        );
    }
}
