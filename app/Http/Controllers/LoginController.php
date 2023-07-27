<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request) {
        
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required']
        ]);

        
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if(Auth::user()->is_password_default && Auth::user()->personnel_id != null){
                return redirect()->intended('/newpassword');
            }
            
            if(Auth::user()->type == 'ADMINISTRATOR' || Auth::user()->type == 'FSIC' || Auth::user()->type == 'FIREDRILL'){
                
                if(Auth::user()->type == 'ADMINISTRATOR')
                    return redirect()->intended('/dashboard');
                else
                    return redirect()->intended('/establishments');
            }   
            else
            return redirect()->intended('/fsec');
        }

        return back()->withErrors([
            'username' => 'The provided credentials is incorrect.',
        ])->onlyInput('username');
    }

    public function logout() {
        
        auth()->logout();

        return redirect('/');
    }
}
