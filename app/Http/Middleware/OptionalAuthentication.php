<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class OptionalAuthentication extends Authenticate
{
    public function handle($request, Closure $next, ...$guards)
    {
        Auth::shouldUse('api');
        return $next($request);
    }
}
