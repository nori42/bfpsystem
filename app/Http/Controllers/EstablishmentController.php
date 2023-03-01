<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

// USE Establishment Mode to communicate with the database
use App\Models\Establishment;
use App\Models\Owner;

class EstablishmentController extends Controller
{
    public function index(){

        // $establishments = Establishment::orderBy('created_at', 'DESC')->get();
        $establishments = DB::table('establishments')
        ->join('owners', 'establishments.owner_id', '=', 'owners.owner_id')
        ->select('establishments.*', 'owners.*')
        ->orderBy('record_no','DESC')
        ->get();

        return view('establishments.index', [
            'establishments' => $establishments,
            'page_title' => "Establishments"
        ]);
    }


    public function create(){
        return view('establishments.create',[
            'page_title' => "Add Establishment"
        ]);
    }

    public function store(Request $request){

        // instantiate model
        $establishment = new Establishment();
        $owner = new Owner();

        //get Data
        $owner->first_name = $request->firstName;
        $owner->last_name = $request->lastName;
        $owner->middle_name= $request->middleName;
        $owner->contact_no = $request->contactNo;

        $establishment->establishment_name = $request->establishmentName;
        $establishment->corporate_name = $request->corporateName; 
        $establishment->substation = $request->substation;
        $establishment->sub_type = $request->subType;
        $establishment->building_type = $request->buildingType;
        $establishment->no_of_story = $request->noOfStory;
        $establishment->createdBy = "admin";
        $establishment->building_permit_no = $request->buildingPermitNo;
        $establishment->fire_insurance_co = $request->fireInsuranceCo;
        $establishment->latest_permit = $request->latestPermit;
        $establishment->barangay = $request->barangay;
        $establishment->address = $request->address;
        $establishment->status = $request->status;
        $establishment->height = $request->height;
        //instantiate foreign id
        $owners = DB::table('owners')->get();
        $establishment->owner_id = count($owners) + 1;

        //save data to database
        $establishment->save();
        $owner->save();

        return redirect('/establishments')->with(['newPost'=> true,'mssg'=>'New Record Added']);
    }

    //get single record
    public function show() {
        $establishment = DB::table('establishments')
        ->join('owners', 'establishments.owner_id', '=', 'owners.owner_id')
        ->select('establishments.*','owners.*')
        ->where('record_no', (int)request('id'))
        ->first();
        
        return view('establishments.show', [
            'establishment' => $establishment,
            'page_title' => 'Establishment Information' // use to set page title inside the panel
        ]);
    }

    public function show_fsic() {
        $establishment = DB::table('establishments')
        ->join('owners', 'establishments.owner_id', '=', 'owners.owner_id')
        ->where('record_no', (int)request('id'))
        ->where('record_no', (int)request('id'))
        ->first();

        return view('establishments.show_fsic',[
            'establishment' => $establishment,
            'page_title' => 'Fire Safety Inspection Certificate' // use to set page title inside the panel
        ]);
    }

    
}