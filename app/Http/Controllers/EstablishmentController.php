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

        $establishments = Establishment::orderBy('created_at', 'DESC')->get();
        $establishments = DB::table('owners')
        ->join('establishments', 'establishments.owner_id', '=', 'owners.id')
        ->select('establishments.*', 'owners.*')
        ->orderBy('establishments.id','DESC')
        ->get();

        $establishmentsz = Establishment::all();

        return view('establishments.index', [
            'establishments' => $establishments,
            'page_title' => "Establishments"
        ]);
    }


    public function create(){

        //load json files
        $occupancies = json_decode(file_get_contents(public_path() . "/json/occupancy.json"), true);
        $sub_type = json_decode(file_get_contents(public_path() . "/json/subtype.json"), true);

        return view('establishments.create',[
            'page_title' => "Add Establishment",
            'occupancies' => $occupancies,
            'subtype' => $sub_type
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
        //instantiate foreign id
        $ownersCount = Owner::all()->count();
        $establishment->owner_id = $ownersCount + 1;

        //save data to database
        $establishment->save();
        $owner->save();

        return redirect('/establishments')->with(['newPost'=> true,'mssg'=>'New Record Added']);
    }

    //get single record
    public function show() {
        $establishment = DB::table('establishments')
        ->join('owners', 'establishments.owner_id', '=', 'owners.id')
        ->select('establishments.*','owners.*')
        ->where('establishments.id', (int)request('id'))
        ->first();


        $data = DB::table('establishments')
        ->join('owners', 'establishments.owner_id', '=', 'owners.id')
        ->select('establishments.*','owners.*')
        ->where(request('owner_id'))
        ->get();

        $occupancies = json_decode(file_get_contents(public_path() . "/json/occupancy.json"), true);
        $sub_type = json_decode(file_get_contents(public_path() . "/json/subtype.json"), true);



        // $data = DB::table('establishments')->get();
       

        return view('establishments.show', [
            'establishment' => $establishment,
            'data' => $data,
            'occupancies' => $occupancies,
            'subtype' => $sub_type,
            'page_title' => 'Establishment Information' // use to set page title inside the panel
        ]);

     
    }
    

    // update establishment details
    public function update_establishment(Request $request){
        Establishment::where('id', $request->id)->update([
            'establishment_name' => $request->establishmentName,
            'corporate_name' => $request->corporateName,
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

        // $establishment->establishment_name = $request->establishmentName;
        // $establishment->corporate_name = $request->corporateName; 
        // $establishment->substation = $request->substation;
        // $establishment->sub_type = $request->subType;
        // $establishment->building_type = $request->buildingType;
        // $establishment->no_of_story = $request->noOfStory;
        // $establishment->building_permit_no = $request->buildingPermitNo;
        // $establishment->fire_insurance_co = $request->fireInsuranceCo;
        // $establishment->latest_permit = $request->latestPermit;
        // $establishment->barangay = $request->barangay;
        // $establishment->address = $request->address;
        // $establishment->height = $request->height;

        // $establishment->save();
    }

    //Add New Establishment for Existing Owner
    public function create_owner_establishment(Request $request)
    {
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
         $establishment->save();

         return redirect('/establishments')->with(['newPost'=> true,'mssg'=>'New Record Added']);
    }
}