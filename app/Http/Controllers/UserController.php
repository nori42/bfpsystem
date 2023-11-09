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
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function index(){
        
        $users = User::orderBy('type')->get();
        $loggedInUsers = User::where('last_active_at', '>=', now()->subMinutes(5))->whereNotNull('last_active_at')->get();
        return view('users.index',[
           'users' => $users,
           'loggedInUsers' => $loggedInUsers
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

            $activityLog = "Added new User: $user->username Type $user->type";
            
            // ActivityLogger::userLog(auth()->user()->id,$user->type,$user->username);
            ActivityLogger::logActivity($activityLog,'USER');
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

                        return redirect("personnel/{$request->id}");
                    }
                    else
                    {
                        $user->username = $request->username;
                        $user->save();

                        return redirect("personnel/{$request->id}");
                    }
                }
                break;
            case 'updatePassword':
                {
                    $request->validate([
                        'passwordNew' => Password::min(8)->mixedCase()->numbers()
                    ]);
                    
                    if (!Hash::check($request->passwordCurrent, $user->password)) {

                        return redirect("users/{$request->id}")->with('pass_incorrect',true);
                    }

                    $user->password = Hash::make($request->passwordNew);
                    $user->save();

                    return redirect("/logout")->with('toastMssg',"Password successly changed. Please re-login");

                }
                break;
        }
    }

    public function show(Request $request){
        
        if($request->id != auth()->user()->id){
            return redirect()->back();
        }

        $user = User::findOrFail($request->id);

        

        $url = $user->personnel->profile_pic_path;
        
        return view('users.show',[
            'userId' => $request->id,
            'profileUrl' => $url, 
            'user' => $user
        ]);
    }

    public function updateDesignation(Request $request){
        $user = User::findOrFail($request->id);

        $user->type = $request->designation;
        $user->save();

        $name = "{$user->personnel->first_name} {$user->personnel->last_name}";

        $activityLog = "Change the user type of: {$name} to {$request->designation}";
        ActivityLogger::logActivity($activityLog,'USER');

        return redirect("/users/{$user->id}")->with('toastMssg','Designation Changed');
    }
}
