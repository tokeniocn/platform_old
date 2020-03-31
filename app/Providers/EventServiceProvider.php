<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Nwidart\Modules\Facades\Module as ModuleManager;
use Nwidart\Modules\Module;

/**
 * Class EventServiceProvider.
 */
class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        //
    ];

    /**
     * Class event subscribers.
     *
     * @var array
     */
    protected $subscribe = [
        // Frontend Subscribers

        // Auth Subscribers
        \App\Listeners\Frontend\Auth\UserEventListener::class,

        // Admin Subscribers

        // Auth Subscribers
        \App\Listeners\Admin\Auth\User\UserEventListener::class,
        \App\Listeners\Admin\Auth\Role\RoleEventListener::class,
    ];

    /**
     * Register any events for your application.
     */
    public function boot()
    {
        parent::boot();

        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return true;
    }

    /**
     * 获取应该用于发现事件的监听器的目录。
     *
     * @return array
     */
    protected function discoverEventsWithin()
    {
        $paths = [];

        ModuleManager::collections()->each(function($module) {
            /** @var Module $module */
            $paths = $module->getExtraPath('Listeners');
        });

        return $paths;
    }
}
