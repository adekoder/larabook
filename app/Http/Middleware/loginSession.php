<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
class loginSession
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
        /*
            middleware to check if the user seesion is still set
            Then they are redirected to the dashboard immediatly
        */
        if(Auth::check())
        {
            return redirect()->route('dashboard');
        }

        return $next($request);
    }
}
