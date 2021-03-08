<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class EnsureTokenIsValid
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
        if(Auth::check()){
            return $next($request);
            }else{
                return response()->json(['status'=>2]);
            }
    }
}
