<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\View;

class AuthcheckManager
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
        if (!session()->has('LoggedUserManager') && $request->path() !== 'manager-login') {
            return redirect('/manager-login')->with('fail', 'Please log in');
        }
        
        // Check if the user is logged in as manager and trying to access the login page
        if (session()->has('LoggedUserManager') && $request->path() === 'manager-login') {
            return redirect('/manager-home'); // Redirect to home page if already logged in
        }
        
        
        // Check if the 'LoggedUserManager' session exists
        if (session()->has('LoggedUserManager')) {
            $usermanager = session('LoggedUserManager');
            View::share('usermanager', $usermanager);
        }
        
        return $next($request);
    }
}
  
