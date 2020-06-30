<?php

namespace App\Http\Middleware;

use Closure,Auth;

class AdminMiddleware
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
            if(Auth::user()->role_id==3){
                return redirect('/');
            }
        }else{
          return redirect('login');  
        }
        return $next($request);
    }
}
