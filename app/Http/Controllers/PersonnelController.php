<?php

namespace App\Http\Controllers;

use App\Models\Personnel;
use App\Models\Person;
use Illuminate\Http\Request;

class PersonnelController extends Controller
{
    //
    public function index (){

        $personnelList = Personnel::orderBy('designation')->get();
        return view('personnel.index',[
            'personnelList' => $personnelList
        ]);
    }

    public function store (Request $request){
        
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
        $personnel->designation = strtoupper($request->designation);
        $personnel->has_user = false;

        $personnel->save();

        // $personnelList = Personnel::all();

        // return view('personnel.index',[
        //     'personnelList' =>  $personnelList,
        //     'toastMssg' => "Added new personnel"
        // ]);

        return redirect('/personnel')->with("toastMssg","Added new personnel");
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
        $personnel->designation = strtoupper($request->designation);

        $personnel->save();

        return redirect("personnel/{$personnel->id}")->with('toastMssg',"Personnel Updated");
    }
}
