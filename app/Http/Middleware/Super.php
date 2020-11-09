<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class Super
{
    public function handle($request, Closure $next, string $guard = null)
    {
        if (!Auth::user()->isSuper()) {
            return redirect()->route('home.index');
        }

        return $next($request);
    }
}
