<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\AuthcheckStaff;
use Illuminate\Support\Facades\Hash;
use App\Models\Staff;

class indexStaffController extends Controller
{
    public function index(){
        return view('staff-login');
    }

    public function logmeinStaff(Request $request){
        $validated = $request->validate([
            'username' => 'required|min:3',
            'password' => 'required' 
        ]);
        
        $query = Staff::where('username', $request->username)->first();

        if(!$query){
            return back()->with('fails','User not found');

            }else{

            if (Hash::check($request->password, $query->password)) {
                $request->session()->put('LoggedUserStaff',$query);
                    return redirect('staff-home');
            }else{
                return back()->with('fail','Incorrect password');
            }
    }
    }
    
    public function staff_signup(){
        return view('staff-signup');
    }

 
    public function registerStaff(Request $request){
        $validated = $request->validate([
            'fname' => 'required|min:3',
            'lname' => 'required|min:3',
            'username' => 'required|unique:staffs,username',
            'email' => 'required|unique:staffs,email',
            'password' => 'required|confirmed|min:3',
        ]);

        $newAcc= new Staff();
        $newAcc->fname = $request ->fname;
        $newAcc->lname = $request ->lname;
        $newAcc->username = $request ->username;
        $newAcc->email = $request ->email;
        $newAcc->password =Hash::make($request ->password);
        $save = $newAcc ->save();

        if($save){
            return back() ->with('success', 'You have been registered');
        }else{
            return back() ->with('fail', 'Error: Something went wrong');
        }

        $insertToTheDB = DB::table('staffs')->insert([
            'fname' => $request->fname,
            'lname' => $request->lname,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password)

        ]);

        if($insertToTheDB){
            return redirect()->route('staff-signup');
        }
        
    }

   
}
