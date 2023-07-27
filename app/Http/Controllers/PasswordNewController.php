<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PasswordNewController extends Controller
{
    //
    public function index(){
        if(!auth()->user()->is_password_default){
           return redirect()->back();
        }

        return view('users.newPassword');
    }

    public function updatePassword(Request $request){
        $request->validate([
            'password' => Password::min(8)->mixedCase()->numbers()
        ]);

        $user = User::find(auth()->user()->id);
        $user->password = Hash::make($request->password);
        $user->reset_password = null;
        $user->is_password_default = false;
        $user->save();

       auth()->logout();
       return redirect('/');
    }
}
