<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::guard('admins')->check() || Auth::guard('sales')->check()) {
            return $next($request);
        }else{
            if(Auth::guard('admins')->check()){
                return redirect()->route('adminLogin')->with("msg", "Please login first");
            }else{
                return redirect()->route('salesLogin')->with("msg", "Please login first");
            }
        }
    }    
}
