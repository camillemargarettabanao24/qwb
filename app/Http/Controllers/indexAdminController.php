<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\AuthcheckStaff;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class indexAdminController extends Controller
{
    public function index(){
        return view('admin-login');
    }

    public function logmeinAdmin(Request $request){
        $validated = $request->validate([
            'username' => 'required|min:3',
            'password' => 'required' 
        ]);
        
        $query = Admin::where('username', $request->username)->first();

        if(!$query){
            return back()->with('fails','User not found');

            }else{

            if (Hash::check($request->password, $query->password)) {
                $request->session()->put('LoggedUserAdmin',$query);
                    return redirect('admin-home');
            }else{
                return back()->with('fail','Incorrect password');
            }
    }
    }
    
    public function admin_signup(){
        return view('admin-signup');
    }

 
    public function registerAdmin(Request $request){
        $validated = $request->validate([
            'fname' => 'required|min:3',
            'lname' => 'required|min:3',
            'username' => 'required|unique:admin,username',
            'email' => 'required|unique:admin,email',
            'password' => 'required|confirmed|min:3'
        ]);

        $newAcc= new Admin();
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

        $insertToTheDB = DB::table('admin')->insert([
            'fname' => $request->fname,
            'lname' => $request->lname,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password)

        ]);

        if($insertToTheDB){
            return redirect()->route('admin-signup');
        }
        
    }

   
}
