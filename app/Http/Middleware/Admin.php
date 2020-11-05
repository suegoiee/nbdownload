<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class Admin
{
    public function handle($request, Closure $next, string $guard = null)
    {
        if (!Auth::user()->isAdmin()) {
            return redirect()->route('home.index');
        }

        return $next($request);
    }
}
