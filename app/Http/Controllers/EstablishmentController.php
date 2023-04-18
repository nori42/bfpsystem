<?php

namespace App\Http\Controllers;

use App\Models\Corporate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

// USE Establishment Mode to communicate with the database
use App\Models\Establishment;
use App\Models\Owner;
use App\Models\Person;
use Illuminate\Support\Arr;

class EstablishmentController extends Controller
{
    // load index page
    public function index(Request $request)
    {
        $isSearch = false;
        $totalRecords = Establishment::count();

        if($request->search == null)
        {
            // $establishments = Establishment::all()->sortDesc();
            $establishments = Establishment::all()->take(25)->sortDesc();
        }
        else if($request->searchFilter != 'name'){
            $establishments = Establishment::where($request->searchFilter,'LIKE','%'.$request->search.'%')->get()->sortDesc();
            $isSearch = true;
        }
        else
        {   

            $owners = Owner::whereRaw("CONCAT(first_name, ' ', last_name) LIKE '{$request->search}%'")->get()->sortDesc();
            
            $establishments = [];

            foreach ($owners as $owner) {
                foreach($owner->establishment as $establishment)
                {
                    array_push($establishments,$establishment);
                }
            }

            $isSearch = true;
        }

        return view('establishments.index', [
            'establishments' => $establishments,
            'isSearch' => $isSearch,
            'totalRecords' => $totalRecords,
            'page_title' => "Establishments"
        ]);
    }


    public function create(){
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
            'owner' => $owner
        ]);
    }

    public function create_from_owner(Request $request){

        $owner = Owner::where('id', $request->id)->first();

        return view('establishments.create',[
            'page_title' => "Add Establishment",
            'owner' => $owner,
        ]);
    }

    // store new record
    public function store(Request $request){
        
        // instantiate model
        $establishment = new Establishment();
        $person = new Person();
        $corporate = new Corporate();
        $owner = new Owner();
        //get Data
        $person->first_name = strtoupper($request->firstName);
        $person->last_name = strtoupper($request->lastName);
        $person->middle_name =  strtoupper($request->middleName);
        $person->contact_no = $request->contactNoPerson;

        
        $corporate->corporate_name = strtoupper($request->corporateName);
        $corporate->contact_no = ($request->contactNoCorporate);

        $person->save();
        $corporate->save();
        $owner->person_id = $person->id;
        $owner->corporate_id = $corporate->id;
        $owner->save();

        $establishment->establishment_name = strtoupper($request->establishmentName);
        $establishment->substation = strtoupper($request->substation);
        $establishment->sub_type = strtoupper($request->subType);
        $establishment->building_type = strtoupper($request->buildingType);
        $establishment->no_of_storey = $request->noOfStory;
        $establishment->createdBy = strtoupper("admin");
        $establishment->building_permit_no = $request->buildingPermitNo; 
        $establishment->fire_insurance_co = strtoupper($request->fireInsuranceCo);
        $establishment->latest_mayors_permit = $request->latestPermit; 
        $establishment->barangay =  strtoupper($request->barangay);
        $establishment->address = strtoupper($request->address);
        $establishment->height = $request->height;
        $establishment->occupancy = strtoupper($request->occupancy);
        $establishment->owner_id = $owner->id;

        //save establishment data to database
        $establishment->save();
        return redirect('/establishments');        
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
    public function update(Request $request){
        $establishment = Establishment::find($request->id);
        $owner = Owner::find($establishment->owner->id);
        
        $establishment->establishment_name = strtoupper($request->establishmentName);
        $owner->corporate_name = strtoupper($request->corporateName);
        $establishment->substation = strtoupper($request->substation);
        $establishment->sub_type = strtoupper($request->subType);
        $establishment->building_type = strtoupper($request->buildingType);
        $establishment->no_of_storey = strtoupper($request->no_of_storey );
        $establishment->building_permit_no = strtoupper($request->buildingPermitNo );
        $establishment->fire_insurance_co = strtoupper($request->fireInsuranceCo);
        $establishment->latest_mayors_permit = strtoupper($request->latestPermit);
        $establishment->barangay = strtoupper( $request->barangay);
        $establishment->address = strtoupper($request->address);
        $establishment->height = strtoupper($request->height);

        $owner->save();
        $establishment->save();

        // Establishment::where('id', $request->id)->update([
        //     'establishment_name' => $request->establishmentName,    
        //     'substation' => $request->substation,
        //     'sub_type' => $request->subType,
        //     'building_type' => $request->buildingType,
        //     'no_of_storey' => $request->no_of_storey,
        //     'building_permit_no' => $request->buildingPermitNo,
        //     'fire_insurance_co' => $request->fireInsuranceCo,
        //     'latest_permit' => $request->latestPermit,
        //     'barangay' => $request->barangay,
        //     'address' => $request->address,
        //     'height' => $request->height
        // ]);

        return redirect('/establishments'. "/" . $request->id)->with(["mssg" => "Record Updated"]);
    }

    public function destroy(Request $request){
        $establishment = Establishment::find($request->id);

        $establishment->delete();

        error_log($establishment->id." Is Archived");

        return redirect('/establishments')->with(["mssg" => "Record No.".$establishment->id." is moved to archived"]);
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
        $establishment->latest_mayors_permit = $request->latestPermit; 
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