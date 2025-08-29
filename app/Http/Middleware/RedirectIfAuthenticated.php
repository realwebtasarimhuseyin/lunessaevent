<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if ($guard == "admin") {
            if (auth()->guard($guard)->check()) {
                return redirect('/realpanel');
            }
        }
        if ($guard == "web") {
            if (auth()->guard($guard)->check()) {
                return redirect('/');
            }
        }

        return $next($request);
    }
}
