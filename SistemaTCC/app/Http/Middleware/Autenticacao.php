<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Autenticacao
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
        if($request->session()->has('usr_id')){
            return $next($request);
        } else {
            $request->session()->flush();
            return redirect()->route('login');
        }

    }
}
