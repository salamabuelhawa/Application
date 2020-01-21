<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Admin
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
        if(Auth::check()){//check if user is logged in
            if(Auth::user()->isAdmin()){//if logged in user is admin return next request
                return $next($request);
            }

        }
        return redirect('/');//else return it to home page
    }
}
