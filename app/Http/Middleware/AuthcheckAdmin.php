<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\View;

class AuthcheckAdmin
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
        if (!session()->has('LoggedUserAdmin') && $request->path() !== 'admin-login') {
            return redirect('/admin-login')->with('fail', 'Please log in');
        }
        
        // Check if the user is logged in as admin and trying to access the login page
        if (session()->has('LoggedUserAdmin') && $request->path() === 'admin-login') {
            return redirect('/admin-home'); // Redirect to home page if already logged in
        }
        
        
        // Check if the 'LoggedUserAdmin' session exists
        if (session()->has('LoggedUserAdmin')) {
            $userAdmin = session('LoggedUserAdmin');
            View::share('userAdmin', $userAdmin);
        }
        
        return $next($request);
    }
}
  
