<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class StatusMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the user is logged in and has a status of 'active'
        if (Auth::check() && Auth::user()->status !== 'active') {
            // Log the user out and redirect with an error message
            Auth::logout();
            return redirect()->route('login')->with('error', 'Your account is not active. Please contact the administrator.');
        }

        return $next($request);

    }
}
