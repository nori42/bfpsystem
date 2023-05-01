<?php

namespace App\Http\Controllers;

use App\Models\Personnel;
use App\Models\Person;
use Illuminate\Http\Request;

class PersonnelController extends Controller
{
    //
    public function index (){

        $personnelList = Personnel::all();
        return view('personnel.index',[
            'personnelList' => $personnelList
        ]);
    }

    public function store (Request $request){
        
        $person = new Person();
        $personnel = new Personnel();

        $person->first_name = strtoupper($request->firstName);
        $person->middle_name = strtoupper($request->middleName);
        $person->last_name = strtoupper($request->lastName);
        $person->suffix = strtoupper($request->suffix);

        $person->save();

        $personnel->position = strtoupper($request->position);
        $personnel->person_id = $person->id;

        $personnel->save();

        $personnelList = Personnel::all();

        return view('personnel.index',[
            'personnelList' =>  $personnelList,
            'toastMssg' => "Added new personnel"
        ]);
    }
}
