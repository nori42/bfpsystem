<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

// USE Establishment Mode to communicate with the database
use App\Models\Establishment;
use App\Models\Owner;

class EstablishmentController extends Controller
{
    // load index page
    public function index(){

        $establishments = Establishment::all()->sortDesc();

        return view('establishments.index', [
            'establishments' => $establishments,
            'page_title' => "Establishments"
        ]);
    }


    public function create(){

        //load json files
        $occupancies = json_decode(file_get_contents(public_path() . "/json/occupancy.json"), true);
        $sub_type = json_decode(file_get_contents(public_path() . "/json/subtype.json"), true);
        $owner = null;

        return view('establishments.create',[
            'page_title' => "Add Establishment",
            'occupancies' => $occupancies,
            'subtype' => $sub_type,
            'owner' => $owner
        ]);
    }

    public function create_from_owner(Request $request){

        $owner = Owner::where('id', $request->id)->first();

        //load json files
        $occupancies = json_decode(file_get_contents(public_path() . "/json/occupancy.json"), true);
        $sub_type = json_decode(file_get_contents(public_path() . "/json/subtype.json"), true);

        return view('establishments.create',[
            'page_title' => "Add Establishment",
            'occupancies' => $occupancies,
            'subtype' => $sub_type,
            'owner' => $owner
        ]);
    }

    // store new record
    public function store(Request $request){
        
        // instantiate model
        $establishment = new Establishment();
        $owner = new Owner();

        //get Data
        $owner->first_name = strtoupper($request->firstName);
        $owner->last_name = strtoupper($request->lastName);
        $owner->middle_name =  strtoupper($request->middleName);
        $owner->contact_no = $request->contactNo;
        $owner->corporate_name = strtoupper($request->corporateName);

        $establishment->establishment_name = strtoupper($request->establishmentName);
        $establishment->substation = strtoupper($request->substation);
        $establishment->sub_type = strtoupper($request->subType);
        $establishment->building_type = strtoupper($request->buildingType);
        $establishment->no_of_storey = $request->noOfStory;
        $establishment->createdBy = strtoupper("admin");
        $establishment->building_permit_no = $request->buildingPermitNo; 
        $establishment->fire_insurance_co = strtoupper($request->fireInsuranceCo);
        $establishment->latest_permit = $request->latestPermit; 
        $establishment->barangay =  strtoupper($request->barangay);
        $establishment->address = strtoupper($request->address);
        $establishment->status = "Pending"; 
        $establishment->height = $request->height;
        $establishment->occupancy = strtoupper($request->occupancy);
        //instantiate foreign id
        $ownersCount = Owner::all()->count();
        $establishment->owner_id = $ownersCount + 1;

        //save data to database
        $establishment->save();
        $owner->save();

        return redirect('/establishments')->with(['newPost'=> true,'mssg'=>'New Record Added']);
    }

    //get single record
    public function show(Request $request) {
        $establishment = Establishment::find($request->id);
        $ownerEstablishments = Establishment::where('owner_id',$request->id)->get();

        $occupancies = json_decode(file_get_contents(public_path() . "/json/occupancy.json"), true);
        $sub_type = json_decode(file_get_contents(public_path() . "/json/subtype.json"), true);
        $building_type = [
            'Small', 'Medium', 'Large', 'High Rise'
        ];


        // $data = DB::table('establishments')->get();
       

        return view('establishments.show', [
            'establishment' => $establishment,
            'occupancies' => $occupancies,
            'subtype' => $sub_type,
            'ownerEstablishments' => $ownerEstablishments,
            'buildingType' => $building_type,
            'page_title' => 'Establishment Details' // use to set page title inside the panel
        ]);

     
    }
    

    // update establishment details
    public function update_establishment(Request $request){
        Establishment::where('id', $request->id)->update([
            'establishment_name' => $request->establishmentName,    
            'substation' => $request->substation,
            'sub_type' => $request->subType,
            'building_type' => $request->buildingType,
            'no_of_storey' => $request->no_of_storey,
            'building_permit_no' => $request->buildingPermitNo,
            'fire_insurance_co' => $request->fireInsuranceCo,
            'latest_permit' => $request->latestPermit,
            'barangay' => $request->barangay,
            'address' => $request->address,
            'height' => $request->height
        ]);

        return redirect('/establishments'. "/" . $request->record_no);
    }

    //Add New Establishment for Existing Owner
    public function create_owner_establishment(Request $request)
    {
        $establishment = DB::table('establishments')
        ->join('owners', 'establishments.owner_id', '=', 'owners.id')
        ->select('establishments.*','owners.*')
        ->where('establishments.id', (int)request('id'))
        ->first();

        $establishment = new Establishment();

        $establishment->establishment_name = strtoupper($request->establishmentName);
        $establishment->corporate_name = strtoupper($request->corporateName);
        $establishment->substation = strtoupper($request->substation);
        $establishment->sub_type = strtoupper($request->subType);
        $establishment->building_type = strtoupper($request->buildingType);
        $establishment->no_of_storey = $request->noOfStory;
        $establishment->createdBy = strtoupper("admin");
        $establishment->building_permit_no = $request->buildingPermitNo; 
        $establishment->fire_insurance_co = strtoupper($request->fireInsuranceCo);
        $establishment->latest_permit = $request->latestPermit; 
        $establishment->barangay =  strtoupper($request->barangay);
        $establishment->address = strtoupper($request->address);
        $establishment->status = "Pending"; 
        $establishment->height = $request->height;
        $establishment->occupancy = strtoupper($request->occupancy);
        $establishment->owner_id = $request->id;
 
         //save data to database
        //  $establishment->save();

        //  return redirect('/establishments')->with(['newPost'=> true,'mssg'=>'New Record Added']);
    }
}