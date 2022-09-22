<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    //

    public function create()
    {
        
        return view('users.register');

    }

    public function store(Request $request)
    {
       // dd($request);
 
        $formFields=$request->validate([
            

            'name'=>['required','min:3'],
            
            'email'=>['required','email',Rule::unique('users','email')],

            'password'=>'required|confirmed|min:6'
            

        ]);
   
           // dd($request);
        // hasing password

        $formFields['password']= bcrypt($formFields['password']);
       
        
        //creating user
        $user =User::create($formFields);
       
        //
        auth()->login($user);
     
        return redirect('/')->with('message','new user created ');


    }

        public function logout(Request $request)
        {
            auth()->logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken();

            return redirect('/')->with('message','user logged out');
            
        }

        //login form

            public function login()
            {
                return view('users.login');
            }

            
            
            public function authenticate(Request $request)
            {

                $formFields=$request->validate([
                    
                    'email'=>['required','email'],
        
                    'password'=>'required'
                    
                ]);
                
                    if(auth()->attempt($formFields))
                    {
                        $request->session()->regenerate();

                        return redirect('/')->with('message','user logged in');

                    }
            
                    return back()->withErrors(['email'=>'Invalid Credentials'])->onlyInput('email');

            }

}
