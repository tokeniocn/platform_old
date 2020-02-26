<?php

if (! function_exists('app_name')) {
    /**
     * Helper to grab the application name.
     *
     * @return mixed
     */
    function app_name()
    {
        return config('app.name');
    }
}

if (! function_exists('gravatar')) {
    /**
     * Access the gravatar helper.
     */
    function gravatar()
    {
        return app('gravatar');
    }
}

if (! function_exists('home_route')) {
    /**
     * Return the route to the "home" page depending on authentication/authorization status.
     *
     * @return string
     */
    function home_route()
    {
        if (is_backend()) {
            if (auth()->check()) {
                return 'admin.dashboard';
            }

            return 'admin.auth.login';
        }

        if (auth()->check()) {
            return 'frontend.user.dashboard';
        }

        return 'frontend.index';
    }
}


if (! function_exists('is_backend')) {
    /**
     * Return the route to the "home" page depending on authentication/authorization status.
     *
     * @return string
     */
    function is_backend()
    {
        return auth()->getDefaultDriver() == 'admin';
    }
}
