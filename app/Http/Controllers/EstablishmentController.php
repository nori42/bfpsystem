<?php

namespace App\Http\Controllers;

use App\Models\Corporate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

// USE Establishment Mode to communicate with the database
use App\Models\Establishment;
use App\Models\Firedrill;
use App\Models\Inspection;
use App\Models\Owner;
use App\Models\Person;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use PHPUnit\TextUI\Help;

class EstablishmentController extends Controller
{
    // load index page
    public function index(Request $request)
    {
        $issuedThisMonth = [
            'Guadalupe' => Helper::getIssuedFSIC('GUADALUPE',now()->year,now()->month),
            'Labangon' => Helper::getIssuedFSIC('LABANGON',now()->year,now()->month),
            'Lahug' => Helper::getIssuedFSIC('LAHUG',now()->year,now()->month),
            'Mabolo' => Helper::getIssuedFSIC('MABOLO',now()->year,now()->month),
            'Pahina Central' => Helper::getIssuedFSIC('PAHINA CENTRAL',now()->year,now()->month),
            'Pardo' => Helper::getIssuedFSIC('PARDO',now()->year,now()->month),
            'Pari-an' => Helper::getIssuedFSIC('PARI-AN',now()->year,now()->month),
            'San Nicolas' => Helper::getIssuedFSIC('SAN NICOLAS',now()->year,now()->month),
            'Talamban' => Helper::getIssuedFSIC('TALAMBAN',now()->year,now()->month),
            'CBP' => Helper::getIssuedFSIC('CBP',now()->year,now()->month)
        ];


        return view('establishments.index', [
            'issuedThisMonth' => $issuedThisMonth,
            'issuedNewThisMonth' => Helper::getIssuedNewByMonthNFSIC(now()->year,now()->month),
            'issuedThisMonthAll' => Helper::getIssuedAllByMonthFSIC(now()->year,now()->month)
        ]);
    }


    public function create(){
        return view('establishments.create',[
            'page_title' => "Add Establishment"
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

        $owner = Owner::where('first_name',strtoupper($request->firstName))
        ->where('middle_name',strtoupper($request->middleName))
        ->where('last_name',strtoupper($request->lastName))
        ->where('corporate_name',strtoupper($request->corporateName))
        ->first();

        if($owner == null){
            $owner = new Owner();
            //get Data
            $owner->first_name = strtoupper($request->firstName);
            $owner->last_name = strtoupper($request->lastName);
            $owner->middle_name =  strtoupper($request->middleName);
            $owner->suffix = strtoupper($request->suffix);
            $owner->contact_no = $request->contactNo;
            $owner->corporate_name = strtoupper($request->corporateName);
            $owner->save();
        }

        $establishment->establishment_name = strtoupper($request->establishmentName);
        $establishment->substation = strtoupper($request->substation);
        $establishment->sub_type = strtoupper($request->subType);
        $establishment->building_type = strtoupper($request->buildingType);
        $establishment->no_of_storey = $request->noOfStory;
        $establishment->createdBy = strtoupper("admin");
        $establishment->business_permit_no = $request->businessPermitNo; 
        $establishment->building_permit_no = $request->buildingPermitNo; 
        $establishment->fire_insurance_co = strtoupper($request->fireInsuranceCo);
        $establishment->barangay =  strtoupper($request->barangay);
        $establishment->address = strtoupper($request->address);
        $establishment->height = $request->height;
        $establishment->floor_area = $request->floorArea;
        $establishment->hazard_note = $request->hazardNote;
        $establishment->occupancy = strtoupper($request->occupancy);
        $establishment->inspection_is_expired = false;
        $establishment->firedrill_is_expired = false;
        $establishment->owner_id = $owner->id;

        //save establishment data to database
        $establishment->save();

        //Added activity log
        $logMessage = "Added new establishment: $establishment->establishment_name";
        ActivityLogger::logActivity($logMessage,'ESTABLISHMENT');

        return redirect("/establishments/".$establishment->id);       
    }

    //get single record
    public function show(Request $request) {
        
        $establishment = Establishment::find($request->id);

        if($establishment == null)
            return redirect('/404');

        $owner = Owner::find($establishment->owner_id);

        $inspections = Inspection::where('establishment_id',$establishment->id)->whereNotNull('expiry_date')->orderBy('issued_on','asc')->get();
        $firedrills = Firedrill::where('establishment_id',$establishment->id)->whereNotNull('issued_on')->orderBy('issued_on','asc')->get();
        
        $occupancies = json_decode(file_get_contents(public_path() . "/json/selectOptions/occupancy.json"), true);
        $sub_type = json_decode(file_get_contents(public_path() . "/json/selectOptions/subtype.json"), true);
        $building_type = [
            'Small', 'Medium', 'Large', 'High Rise'
        ];       

        return view('establishments.show', [
            'establishment' => $establishment,
            'inspections' => $inspections,
            'firedrills' => $firedrills,
            'occupancies' => $occupancies,
            'subtype' => $sub_type,
            'owner' => $owner,
            'buildingType' => $building_type,
            'page_title' => 'Establishment Details' // use to set page title inside the panel
        ]);
    }

    public function edit(Request $request) {
        
        $establishment = Establishment::find($request->id);

        if($establishment == null)
            return redirect('/404');

        $owner = Owner::find($establishment->owner_id);
        
        $occupancies = json_decode(file_get_contents(public_path() . "/json/selectOptions/occupancy.json"), true);
        $sub_type = json_decode(file_get_contents(public_path() . "/json/selectOptions/subtype.json"), true);
        $building_type = [
            'Small', 'Medium', 'Large', 'High Rise'
        ];       

        return view('establishments.edit', [
            'establishment' => $establishment,
            'occupancies' => $occupancies,
            'subtype' => $sub_type,
            'owner' => $owner,
            'buildingType' => $building_type,
            'page_title' => 'Establishment Details' // use to set page title inside the panel
        ]);
    }

    public function search(Request $request){

        $establishment = Establishment::find($request->dataId);
        
        //If record does not exist
        if($establishment == null)
        {
            return redirect()->back()->with('searchQuery',strtoupper($request->search));
        }
         

        //Get all inspection and firedrill that is not printed
        $inspections = Inspection::where('establishment_id',$establishment->id)->whereNotNull('expiry_date')->get();
        $firedrills = Firedrill::where('establishment_id',$establishment->id)->whereNotNull('issued_on')->get();

        if($establishment == null)
        return redirect()->back()->with(["MSSG"=>"No Result","SEARCH"=>$request->search]);


        $owner = Owner::find($establishment->owner_id);
                
        $occupancies = json_decode(file_get_contents(public_path() . "/json/selectOptions/occupancy.json"), true);
        $sub_type = json_decode(file_get_contents(public_path() . "/json/selectOptions/subtype.json"), true);
        $building_type = [
            'Small', 'Medium', 'Large', 'High Rise'
        ];       

        return view('establishments.show', [
            'establishment' => $establishment,
            'inspections' => $inspections,
            'firedrills' => $firedrills,
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
        
        $establishment->establishment_name = strtoupper($request->establishmentName);
        $establishment->substation = strtoupper($request->substation);
        $establishment->occupancy = strtoupper($request->occupancy);
        $establishment->sub_type = strtoupper($request->subType);
        $establishment->building_type = strtoupper($request->buildingType);
        $establishment->no_of_storey = strtoupper($request->noOfStory );
        $establishment->business_permit_no = strtoupper($request->businessPermitNo );
        $establishment->fire_insurance_co = strtoupper($request->fireInsuranceCo);
        $establishment->barangay = strtoupper( $request->barangay);
        $establishment->address = strtoupper($request->address);
        $establishment->height = strtoupper($request->height);
        $establishment->floor_area = strtoupper($request->floorArea);

        // Only log if there are changes
        if($establishment->isDirty()){
            // ActivityLogger::establishmentLog($establishment->establishment_name,Activity::UpdateEstablishment);
            $logMessage = "Updated the establishment: $establishment->establishment_name";
            ActivityLogger::logActivity($logMessage,'ESTABLISHMENT');
        }

        $establishment->save();


        return redirect('/establishments'. "/" . $establishment->id)->with(["mssg" => "Record Updated"]);
    }

    public function destroy(Request $request){
        $establishment = Establishment::find($request->id);
        $establishment->delete();

        // ActivityLogger::establishmentLog($establishment->establishment_name,Activity::DeleteEstablishment);
        $logMessage = "Deleted the establishment: $establishment->establishment_name";
        ActivityLogger::logActivity($logMessage,'ESTABLISHMENT');
        return redirect('/establishments')->with(["deleteSuccess" => "Establishment successfully deleted"]);
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