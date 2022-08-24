<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RestrictIpAddressMiddleware
{
    public $whitelist = ['127.0.0.1','localhost'];
    public function handle($request, Closure $next){
        if (!in_array($request->ip(), $this->whitelist)) {
            return response()->json(['success'=>false,'message' => "You are not allowed to access this site."],401);
        }
        return $next($request);
    }     
}
