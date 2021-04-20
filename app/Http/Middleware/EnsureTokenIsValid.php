<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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
        // \Log::debug(print_r($next));
        // \Log::debug($request);
        // if ($request->user_id) {
        //     return response()->json(['status'=>"aaa"]);
        // }
        if(Auth::check()){
            return $next($request);
            }else{
                return response()->json(['status'=>2]);
            }
    }
}
