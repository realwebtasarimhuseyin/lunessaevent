<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class KuponKontrolMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // İzin verilen URL'ler
        $allowedUrls = [
            '/odeme',
        ];

        if (!in_array($request->getRequestUri(), $allowedUrls)) {
            session()->forget('kupon_kod');
        }

        return $next($request);
    }
}
