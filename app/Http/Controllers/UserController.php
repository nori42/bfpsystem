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

class UserController extends Controller
{
    public function index(){
        
        $users = User::all();
        $personnelList = Personnel::whereNotNull('person_id')
        ->where('person_id', '!=', 0)
        ->where('has_user', false)
        ->get();

        return view('users.index',[
           'personnelList' => $personnelList,
           'users' => $users
        ]);
    }


    public function store(Request $request) {

        $user = new User;

        $user->username = $request->username;
        $user->password = Hash::make($request->password);
        $user->personnel_id = $request->personnelId;
        $user->type = $request->type;

        try{
            $user->save();
        }
        catch(QueryException $e)
        {
            if ($e->errorInfo[1] == 1062) {
            $message = 'The record already exists in the database.';

            $users = User::all();

            // Retrieve all personnel that has no user
            $personnelList = Personnel::whereNotNull('person_id')
            ->where('person_id', '!=', 0)
            ->where('has_user', false)
            ->get();
            
            return view('users.index',[
                'personnelList' => $personnelList,
                'users' => $users,
                'toastMssg' => "Username already exist"
            ]);
        }
        }

        // Update Has User
        $personnel = Personnel::find($request->personnelId);

        $personnel->has_user = true;

        $personnel->save();
        
        $users = User::all();

        // Retrieve all personnel that has no user
        $personnelList = Personnel::whereNotNull('person_id')
        ->where('person_id', '!=', 0)
        ->where('has_user', false)
        ->get();
        
        return view('users.index',[
            'personnelList' => $personnelList,
            'users' => $users,
            'toastMssg' => "Added new personnel"
         ]);
    }

    public function show(Request $request){
        return view('users.show',[
            'userId' => $request->id
        ]);
    }
}
