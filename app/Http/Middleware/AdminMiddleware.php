<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!Auth::user()) {
            return redirect()->route('login');
        }

        if (!Auth::user()->isAdmin()) {
            return redirect()->route('login');
        }

        // Set variables used in dashboard
        // ...

        return $next($request);
    }
}
