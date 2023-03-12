<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

// USE Establishment Mode to communicate with the database
use App\Models\Establishment;
use App\Models\Owner;
use Illuminate\Support\Arr;

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
        
        $allOwners = Owner::all();

        $nameList = array();
        
        foreach($allOwners as $owners)
        {
            array_push($nameList, $owners['first_name'].", ".$owners['middle_name'].", ".$owners['last_name']);
        }

        $allOwnersJson = json_encode($allOwners);


        return view('establishments.create',[
            'page_title' => "Add Establishment",
            'occupancies' => $occupancies,
            'subtype' => $sub_type,
            'owner' => $owner,
            'nameList' => $nameList,
            'allOwnersJson' => $allOwnersJson
        ]);
    }

    public function create_from_owner(Request $request){

        $owner = Owner::where('id', $request->id)->first();
        $allOwners = Owner::all();

        //load json files
        $occupancies = json_decode(file_get_contents(public_path() . "/json/occupancy.json"), true);
        $sub_type = json_decode(file_get_contents(public_path() . "/json/subtype.json"), true);

        $allOwnersJson = json_encode($allOwners);

        return view('establishments.create',[
            'page_title' => "Add Establishment",
            'occupancies' => $occupancies,
            'subtype' => $sub_type,
            'owner' => $owner,
            'allOwnersJson' => $allOwnersJson
        ]);
    }

    // store new record
    public function store(Request $request){
        
        // instantiate model
        $establishment = new Establishment();
        $owner = new Owner();

        //this id is store_from_owner route
        // $request->store_from_owner_id

        //this id is from store route for autocomplete to work
        // $request->ownerId
        
        //get Data

        if(!isset($request->store_from_owner_id) && !isset($request->ownerId)){
            $owner->first_name = strtoupper($request->firstName);
            $owner->last_name = strtoupper($request->lastName);
            $owner->middle_name =  strtoupper($request->middleName);
            $owner->contact_no = $request->contactNo;
            $owner->corporate_name = strtoupper($request->corporateName);
        }

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
        //Save owner first to get the id
        $owner->save();

        if(!isset($request->store_from_owner_id) && !isset($request->ownerId)){
            $establishment->owner_id = $owner->id;
        }
        else
        {
            //When using the new establishment for creating
            if(isset($request->ownerId))
            {
                //When using the new establishment for creating
                $establishment->owner_id = $request->ownerId;
            }
            else
            {
                //When using the add new establishment for this owner
                $establishment->owner_id = $request->store_from_owner_id;
            }
        }

        //save establishment data to database
        $establishment->save();
        

        return redirect('/establishments')->with(['newPost'=> true,'mssg'=>'New Record Added']);
    }

    //get single record
    public function show(Request $request) {
        $establishment = Establishment::find($request->id);
        $owner = Owner::find($establishment->owner_id);
        
        $occupancies = json_decode(file_get_contents(public_path() . "/json/occupancy.json"), true);
        $sub_type = json_decode(file_get_contents(public_path() . "/json/subtype.json"), true);
        $building_type = [
            'Small', 'Medium', 'Large', 'High Rise'
        ];       

        return view('establishments.show', [
            'establishment' => $establishment,
            'occupancies' => $occupancies,
            'subtype' => $sub_type,
            'owner' => $owner,
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