<?php

namespace App\Http\Middleware;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Middleware\Authenticate as Middleware;


/**
 * Class Authenticate.
 */
class Authenticate extends Middleware
{

    protected function unauthenticated($request, array $guards)
    {
        $redirectTo = null;
        if (!$request->expectsJson()) {
            $redirectTo = route(in_array('admin', $guards) ? 'admin.auth.login' : home_route());
        }

        throw new AuthenticationException(
            'Unauthenticated.', $guards, $redirectTo
        );
    }
}
