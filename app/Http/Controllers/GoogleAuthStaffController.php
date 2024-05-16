<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\Staff;


class GoogleAuthStaffController extends Controller
{
    public function redirect_staff()
    {
        return Socialite::driver('google')->scopes(['openid', 'profile', 'email'])->redirect();
    }

    public function callbackGoogleStaff(){
        try {

            $google_staff = Socialite::driver('google')->user();

            $staff = Staff::where('google_id', $google_staff->getID())->first();

            if(!$staff){

                //if staff exists
                $staff_exists = Staff::where('email', $google_staff->getEmail())->first();

                if ($staff_exists){
                    Auth::login($staff_exists);
                    return redirect()->route('staff-home');
                }

                //if staff does not exist
                $new_staff = Staff::create([
                    'name' => $google_staff->getName(),
                    'email' => $google_staff->getEmail(),
                    'google_id' => $google_staff->getId(),
                    'username' => $google_staff->getName(),
                ]);

                Auth::login($new_staff);
                return redirect()->route('staff-home');

            }
            else{
                Auth::login($staff);
                return redirect()->route('staff-home');
            }

        } catch(\Throwable $th) {
            \Log::error("Something went wrong! " . $th->getMessage());
            \Log::error("Socialite user data: " . print_r(Socialite::driver('google')->stateless()->user(), true));
            }
    }

  
}
