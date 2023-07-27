<?php

namespace App\Http\Controllers;

use App\Models\Personnel;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function index(){
        
        $users = User::orderBy('type')->get();

        return view('users.index',[
           'users' => $users
        ]);
    }


    public function store(Request $request) {

        $user = new User;

        $user->username = $request->username;
        $user->password = Hash::make($request->password);
        $user->name = strtoupper($request->name);
        $user->personnel_id = $request->assignedTo;
        $user->type = $request->type;

        try{

            $user->save();

            ActivityLogger::userLog(auth()->user()->id,$user->type,$user->username);
        }
        catch(QueryException $e)
        {   
            error_log($e->getMessage());

            if ($e->errorInfo[1] == 1062) {
            return redirect()->back()->with("toastMssg","Username already exist");
        }
        }

         return redirect('/users')->with("toastMssg","Added new user");
    }
    
    public function update(Request $request){
        $user = User::find($request->id);


        switch($request->action){
            case 'updateUsername':
                {
                    if(User::where('username', $request->username)->exists()){

                        return view('users.show',[
                            'userId' => $request->id,
                            'user' => $user,
                            'toastMssg' => "Username already exist try again"
                        ]);
                    }
                    else
                    {
                        $user->username = $request->username;
                        $user->save();

                        return view('users.show',[
                            'userId' => $request->id,
                            'user' => $user,
                            'toastMssg' => "Username changed"
                        ]);
                    }
                }
                break;
            case 'updatePassword':
                {
                    $request->validate([
                        'passwordNew' => Password::min(8)->mixedCase()->numbers()
                    ]);
                    
                    if (!Hash::check($request->passwordCurrent, $user->password)) {
                        return view('users.show',[
                            'userId' => $request->id,
                            'user' => $user,
                            'toastMssg' => "Enter the correct password and try again"
                        ]);
                    }

                    $user->password = Hash::make($request->passwordNew);
                    $user->save();

                    return view('users.show',[
                        'userId' => $request->id,
                        'user' => $user,
                        'toastMssg' => "Password changed"
                    ]);
                }
                break;
        }
    }

    public function show(Request $request){
        return view('users.show',[
            'userId' => $request->id,
            'user' => User::find($request->id)
        ]);
    }
}
