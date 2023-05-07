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
            $user = Auth::user();
 
            return redirect()->intended('/establishments');
        }

        return back()->withErrors([
            'username' => 'The provided credentials does not exist in the system.',
        ])->onlyInput('username');
    }

    public function logout() {
        
        auth()->logout();

        return redirect('/');
    }
}
