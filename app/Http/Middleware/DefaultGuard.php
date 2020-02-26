<?php

namespace App\Http\Middleware;

use Closure;

class DefaultGuard
{
    public function handle($request, Closure $next, $guard)
    {
        auth()->shouldUse($guard);

        return $next($request);
    }
}
