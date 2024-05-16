<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Authcheck;
use Illuminate\Support\Facades\Hash;
use App\Models\Customer;

class indexController extends Controller
{
    public function customer_login(){        
        return view('customer-login');
    }

    public function logmein(Request $request){
        $validated = $request->validate([
            'username' => 'required|min:3',
            'password' => 'required'
        ]);
        
        $query = Customer::where('username', $request->username)->first();

        if(!$query){
            return back()->with('fails','User not found');

            }else{

            if (Hash::check($request->password, $query->password)) {
                $request->session()->put('LoggedUser',$query);
                    return redirect('customer-home');
            }else{
                return back()->with('fail','Incorrect password');
            }
    }
    }
    
    public function customer_signup(){
        return view('customer-signup');
    }

 
    public function register(Request $request){
        $validated = $request->validate([
            'fname' => 'required|min:3',
            'lname' => 'required|min:3',
            'username' => 'required|unique:customers,username', 
            'email' => 'required|unique:customers,email',
            'password' => 'required|confirmed|min:3',
            'phone_number' => 'nullable|string',
            'province' => 'nullable|string',
            'city_municipality' => 'nullable|string',
            'barangay' => 'nullable|string'
        ]);

        $newAcc= new Customer();
        $newAcc->fname = $request ->fname;
        $newAcc->lname = $request ->lname;
        $newAcc->username = $request ->username;
        $newAcc->email = $request ->email;
        $newAcc->phone_number = $request ->phone_number;
        $newAcc->province = $request ->province;
        $newAcc->city_municipality = $request ->city_municipality;
        $newAcc->barangay = $request ->barangay;
        $newAcc->password =Hash::make($request ->password);
        $save = $newAcc ->save();

        if($save){
            return back() ->with('success', 'You have been registered');
        }else{
            return back() ->with('fail', 'Something went wrong. Please make sure the fields are filled out correctly.');
        }

        $insertToTheDB = DB::table('customers')->insert([
            'fname' => $request->fname,
            'lname' => $request->lname,
            'username' => $request->username,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'province' => $request->province,
            'city_municipality' => $request->city_municipality,
            'barangay' => $request->barangay,
            'password' => Hash::make($request->password)

        ]);

        if($insertToTheDB){
            return redirect()->route('customer-signup');
        }
    }
}
