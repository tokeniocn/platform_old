<?php
use App\Models\Auth\User;
use App\Models\Admin\AdminUser;

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

if (! function_exists('home_route')) {
    /**
     * Return the route to the "home" page depending on authentication/authorization status.
     *
     * @return string
     */
    function home_route()
    {
        if (in_admin()) {
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


if (! function_exists('in_admin')) {
    /**
     * Return the route to the "home" page depending on authentication/authorization status.
     *
     * @return string
     */
    function in_admin()
    {
        return auth()->getDefaultDriver() == 'admin';
    }
}

if (! function_exists('with_admin_user')) {
    /**
     * @return AdminUser
     */
    function with_admin_user($userIdOrUser)
    {
        if ($userIdOrUser instanceof AdminUser) {
            return $userIdOrUser;
        }

        return AdminUser::first($userIdOrUser);
    }
}

if (! function_exists('with_user')) {
    /**
     *
     * @return User
     */
    function with_user($userIdOrUser)
    {
        if ($userIdOrUser instanceof User) {
            return $userIdOrUser;
        }

        return User::first($userIdOrUser);
    }
}
