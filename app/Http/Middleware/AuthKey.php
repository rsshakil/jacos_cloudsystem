<?php

namespace App\Http\Middleware;

use Closure;

class AuthKey
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
        $access_token = $request->header('APP_KEY');
        if($access_token!='Qe75ymSr'){
            return response()->json(['message'=>'api athorization faild',401]);
        }
        return $next($request);
    }
}
