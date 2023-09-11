<?php

namespace App\Http\Controllers;

use App\Models\Personnel;
use App\Models\Person;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PersonnelController extends Controller
{
    //
    public function index (){

        $usersList = User::orderBy('type')->get();
        $personnelCount = Personnel::count();
        return view('personnel.index',[
            'usersList' => $usersList,
            'personnelCount' => $personnelCount
        ]);
    }

    public function create(){

        if(auth()->user()->personnel_id != null)
        {
           return redirect()->back();
        }

        return view('personnel.create');
    }

    public function store (Request $request){
        $request->validate([
            'password' => Password::min(8)->mixedCase()->numbers()
        ]);
        
        $user = User::find(auth()->user()->id);

        $personnel = new Personnel();

        $personnel->first_name = strtoupper($request->firstName);
        $personnel->middle_name = strtoupper($request->middleName);
        $personnel->last_name = strtoupper($request->lastName);
        $personnel->name_suffix = strtoupper($request->nameSuffix);
        $personnel->sex = strtoupper($request->sex);
        $personnel->date_of_birth = $request->dateOfBirth;
        $personnel->contact_no = strtoupper($request->contactNo);
        $personnel->address = strtoupper($request->address);
        $personnel->name_suffix = strtoupper($request->nameSuffix);
        $personnel->rank = strtoupper($request->rank);
        $personnel->user_id = $user->id;

        $personnel->save();

        $user->personnel_id = $personnel->id;
        $user->password = Hash::make($request->password);
        $user->reset_password = null;
        $user->is_password_default = false;
        $user->save();
        // $personnelList = Personnel::all();

        // return view('personnel.index',[
        //     'personnelList' =>  $personnelList,
        //     'toastMssg' => "Added new personnel"
        // ]);
        
        if(auth()->user()->type == 'ADMINISTRATOR')
        {
            return redirect('/dashboard');
        }
        else if(auth()->user()->type == 'FSIC' || auth()->user()->type == 'FIREDRILL')
        {
            return redirect('/establishments');

        }
        else
        {
            return redirect('/fsec');
        }
    }

    public function show(Request $request){
        $personnel = Personnel::find($request->id);

        if($personnel == null){
            return view('errors.404');
        }

        return view('personnel.show',[
            'personnel' => $personnel
        ]);
    }

    public function edit (Request $request){
        $personnel = Personnel::find($request->id);

        if($personnel == null){
            return view('errors.404');
        }
        return view('personnel.edit',['personnel'=>$personnel]);
    }

    public function update(Request $request){
        $personnel = Personnel::find($request->id);

        $personnel->first_name = strtoupper($request->firstName);
        $personnel->middle_name = strtoupper($request->middleName);
        $personnel->last_name = strtoupper($request->lastName);
        $personnel->name_suffix = strtoupper($request->nameSuffix);
        $personnel->sex = strtoupper($request->sex);
        $personnel->date_of_birth = $request->dateOfBirth;
        $personnel->contact_no = strtoupper($request->contactNo);
        $personnel->address = strtoupper($request->address);
        $personnel->name_suffix = strtoupper($request->nameSuffix);
        $personnel->rank = strtoupper($request->rank);

        $personnel->save();

        return redirect("users/{$personnel->user->id}")->with('toastMssg',"Personnel Updated");
    }

    public function destroy(Request $request){
        $personnel = Personnel::find($request->id);

        $user = $personnel->user;

        $personnel->delete();
        $user->delete();

        return redirect('/personnel')->with(["toastMssg" => "Personnel successfully deleted"]);;
    }
}
