<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class Josh
{
    public function handle($request, Closure $next, string $guard = null)
    {
        if (!Auth::user()->isJosh()) {
            return redirect()->route('home.index');
        }

        return $next($request);
    }
}
