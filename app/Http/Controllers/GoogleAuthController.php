<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\Customer;


class GoogleAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->scopes(['openid', 'profile', 'email'])->redirect();
    }

    public function callbackGoogle(){
        try {

            $google_user = Socialite::driver('google')->user();

            $user = Customer::where('google_id', $google_user->getId())->first();

            if(!$user){

                //if user exists
                $user_exists = Customer::where('email', $google_user->getEmail())->first();

                if ($user_exists){
                    Auth::login($user_exists);
                    return redirect()->route('customer-home');
                }

                //if user does not exist
                $new_user = Customer::create([
                    'name' => $google_user->getName(),
                    'email' => $google_user->getEmail(),
                    'google_id' => $google_user->getId(),
                    'username' => $google_user->getName(),
                ]);

                Auth::login($new_user);
                return redirect()->route('customer-home');
 
            }
            else{
                Auth::login($user);
                return redirect()->route('customer-home');
            }

        } catch(\Throwable $th) {
            \Log::error("Something went wrong! " . $th->getMessage());
            \Log::error("Socialite user data: " . print_r(Socialite::driver('google')->stateless()->user(), true));
                    }
    }

  
}
