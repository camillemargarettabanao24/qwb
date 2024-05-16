<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;


class Authcheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!session()->has('LoggedUser') && $request->path() !='/customer-login'){
            return redirect('/customer-login')->with ('fail', 'please login');
        }
        if (session()->has('LoggedUser') && $request->path()=='/customer-login'){
            return back();
        }
        
        // Check if the 'LoggedUser' session exists
        if (session()->has('LoggedUser')) {
            $user = session('LoggedUser');
            View::share('user', $user);
        }
        
        return $next($request);
    }
}
