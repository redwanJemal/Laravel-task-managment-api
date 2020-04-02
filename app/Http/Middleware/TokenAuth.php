<?php

namespace App\Http\Middleware;

use Closure;

class TokenAuth
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
        $token = $request->header('X-API-Token');
        if('test-token-value' != $token){
            return response()->json('Auth Token Not Available', 401,);
        }
        return $next($request);
    }
}
