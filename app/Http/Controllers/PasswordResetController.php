<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PasswordResetController extends Controller
{
    //
    public function requestPasswordReset(Request $request){
        
        $user = User::where('username',$request->username)->first();

        if($user === null){
            return back()->withErrors(['username'=>'Username does not exist in the system']);
        }

        if($user->request_password_reset){
            return view('users.passwordReset',[
                'resetSent'=> true,
                'resetAlreadySent' => true
            ]);
        }

        $user->request_password_reset = true;

        $user->save();

        return view('users.passwordReset',[
            'resetSent'=> true,
            'resetAlreadySent' => false
        ]);

    }
    

    
    public function resetPassword(Request $request){
        $newpassword = Helper::randPass(8);

        $user = User::find($request->userId);
        $user->password = Hash::make($newpassword);
        $user->request_password_reset = false;
        $user->is_password_default = true;
        $user->save();

        $users = User::all();

        return view('users.index',[
           'users' => $users,
           'toastMssg' => 'Password Reset',
           'newpassword' => ['id'=>$user->id,'password'=>$newpassword]
        ]);
    }
}
