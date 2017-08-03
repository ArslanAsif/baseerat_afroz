<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class EditorAdmin
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
        if(Auth::guest())
        {
            return redirect('/')->with('error', 'Admin & Editor access only');
        }

        if(Auth::user()->type == 'editor' || Auth::user()->type == 'admin')
        {
            return $next($request);
        }

        return redirect('/')->with('error', 'Admin & Editor access only');
    }
}
