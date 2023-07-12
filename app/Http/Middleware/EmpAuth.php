<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class EmpAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::check())
        {

              if(Auth::user()->role==0){
                //he is not admin
                    return $next($request);

              }   
              else{
                return redirect()->route('admin_home')->with('error','Access Denied');

              }

        }else{
            return redirect()->route('home')->with('error','Please Login to access');


        }
    }
}
