<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\View;

class AuthcheckStaff
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
        if (!session()->has('LoggedUserStaff') && $request->path() !== 'staff-login') {
            return redirect('/staff-login')->with('fail', 'Please log in');
        }
        
        // Check if the user is logged in as staff and trying to access the login page
        if (session()->has('LoggedUserStaff') && $request->path() === 'staff-login') {
            return redirect('/staff-home'); // Redirect to home page if already logged in
        }
        
        
        // Check if the 'LoggedUserStaff' session exists
        if (session()->has('LoggedUserStaff')) {
            $userStaff = session('LoggedUserStaff');
            View::share('userStaff', $userStaff);
        }
        
        return $next($request);
    }
}
  
