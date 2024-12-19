<?php

namespace Spatie\Permission\Middlewares;

use Closure;
use Illuminate\Support\Facades\Auth;

class PermissionMiddleware
{
    public function handle($request, Closure $next, $permission)
    {
        if (Auth::guest()) {
            abort(403);
        }

        if (! Auth::user()->can($permission)) {
            abort(403);
        }

        return $next($request);
    }
}
