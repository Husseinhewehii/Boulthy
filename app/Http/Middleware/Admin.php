<?php

namespace App\Http\Middleware;

use App\Constants\Status_Responses;
use Closure;
use Illuminate\Http\Request;

class Admin
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
        $user = auth()->user();
        return ($user->isAdmin() || $user->isSuperAdmin()) ?
         $next($request) : unauthorized_response();
    }
}
