<?php

namespace App\Http\Middleware;

use App\Constants\Status_Responses;
use Closure;
use Illuminate\Http\Request;

class OTP
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
        if(auth()->check()){
            $user = auth()->user();
            if($user->otp && $user->otp_expiration < now())
            {
                $user->resetOTP();
                $token = $user->token();
                $token->revoke();
                return unauthorized_response();
            }
        }
        return $next($request);
    }
}
