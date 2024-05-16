<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\AuthcheckManager;
use Illuminate\Support\Facades\Hash;
use App\Models\Manager;

class indexManagerController extends Controller
{
    public function index(){
        return view('manager-login');
    }

    public function logmeinManager(Request $request){
        $validated = $request->validate([
            'username' => 'required|min:3',
            'password' => 'required' 
        ]);
        
        $query = Manager::where('username', $request->username)->first();

        if(!$query){
            return back()->with('fails','User not found');

            }else{

            if (Hash::check($request->password, $query->password)) {
                $request->session()->put('LoggedUserManager',$query);
                    return redirect('manager-login');
            }else{
                return back()->with('fail','Incorrect password');
            }
    }
    }
    
    public function manager_signup(){
        return view('manager-signup');
    }

 
    public function registerManager(Request $request){
        $validated = $request->validate([
            'fname' => 'required|min:3',
            'lname' => 'required|min:3',
            'username' => 'required|unique:managers,username',
            'email' => 'required|unique:managers,email',
            'password' => 'required|confirmed|min:3',
        ]);

        $newAcc= new Manager();
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

        $insertToTheDB = DB::table('managers')->insert([
            'fname' => $request->fname,
            'lname' => $request->lname,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password)

        ]);

        if($insertToTheDB){
            return redirect()->route('manager-signup');
        }
        
    }
    
    public function manager_home(){
        return view('manager-home');
    }


}
