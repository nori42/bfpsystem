<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Models\BuildingPlan;
use App\Models\Corporate;
use Illuminate\Http\Request;
use App\Models\Establishment;
use App\Models\Evaluation;
use App\Models\File;
use App\Models\Owner;
use App\Models\Person;
use App\Models\Receipt;
use Illuminate\Support\Facades\DB;

class FsecController extends Controller
{
    public function index(Request $request){

        return view('fsec.index');
    }

    public function create(){

        return view('fsec.create');
    }

    public function store(Request $request){
        // Instantiate Models
        $buildingPlan = new BuildingPlan();
        $owner = new Owner();
        $person = new Person();
        $corporate = new Corporate();
        $building = new Building();
        $receipt = new Receipt();

        // Add Owners Fields
        $person->first_name = strtoupper($request->firstName);
        $person->middle_name = strtoupper($request->middleName);
        $person->last_name = strtoupper($request->lastName);
        $person->save();

        $corporate->corporate_name = strtoupper($request->corporateName);
        $corporate->save();

        $owner->person_id = $person->id;
        $owner->corporate_id = $corporate->id;
        $owner->save();

        // Add Building Fields
        $building->occupancy = strtoupper($request->occupancy);
        $building->sub_type = strtoupper($request->subType);
        $building->building_story = strtoupper($request->buildingStory);
        $building->floor_area = strtoupper($request->floorArea);
        $building->address = strtoupper($request->address);
        $building->save();

        //Add Receipt Fields

        // $payor =$person != null ? $person->first_name.' '.$person->middle_name.' '.$person->last_name : $corporate->corporate_name;

        $receipt->or_no = $request->orNo;
        $receipt->payor = $owner->id;
        $receipt->receipt_for = "FSEC";
        $receipt->amount = $request->amountPaid;
        $receipt->date_of_payment = $request->dateOfPayment;
        $receipt->save();

        //Add Evaluation Fields
        $buildingPlan->name_of_building = strtoupper($request->buildingName);
        $buildingPlan->series_no = (sprintf("%04d",count(BuildingPlan::all()) + 1)).'-S\''.date('Y');
        $buildingPlan->bp_application_no = strtoupper($request->bpApplicationNo);
        $buildingPlan->bill_of_materials = strtoupper($request->billOfMaterials);
        $buildingPlan->date_received = $request->dateReceived;
        $buildingPlan->owner_id = $owner->id;
        $buildingPlan->building_id = $building->id;
        $buildingPlan->receipt_id = $receipt->id;
        $buildingPlan->save();

        return redirect('/fsec'.'/'.$buildingPlan->id);
    }

    public function show(Request $request)
    {
        $buildingPlan = BuildingPlan::find($request->id);
        $evaluations = Evaluation::all()->where('building_plan_id',$buildingPlan->id);

        return view('fsec.show',[
            'buildingPlan' => $buildingPlan,
            'evaluations' => $evaluations
        ]);
    }

    public function edit(Request $request){
        $buildingPlan = BuildingPlan::find($request->id);

        return view('fsec.edit',[
            'buildingPlan' => $buildingPlan
        ]);
    }

    public function update(Request $request){
        $buildingPlan = BuildingPlan::find($request->id);
        $receipt = $buildingPlan->receipt;
        $building = $buildingPlan->building;

        //Update Evaluation Fields
        $buildingPlan->name_of_building = strtoupper($request->buildingName);
        $buildingPlan->bill_of_materials = strtoupper($request->billOfMaterials);
        $buildingPlan->save();

        //Update Building Fields
        $building->occupancy = strtoupper($request->occupancy);
        $building->sub_type = strtoupper($request->subType);
        $building->building_story = strtoupper($request->buildingStory);
        $building->floor_area = strtoupper($request->floorArea);
        $building->address = strtoupper($request->address);
        $building->save();

        //Update Receipt Fields
        $receipt->or_no = $request->orNo;
        $receipt->amount = $request->amountPaid;
        $receipt->date_of_payment = $request->dateOfPayment;
        $receipt->save();

        return redirect('/fsec'.'/'.$buildingPlan->id)->with(["mssg" => "Application Updated"]);
    }
    //Attachment
    public function show_attachment(Request $request)
    {
        $establishment = Establishment::where('id', $request->id)->first();
        $owner = Owner::where('id', $request->id)->first();
        $establishment_id = $request->id;
        $attachFor = $request->attachFor;
        $files = File::whereHas('attachments', function ($query) use ($establishment_id,$attachFor) {
            $query->where('establishment_id', $establishment_id)->where('attach_for', $attachFor);
        })->get();

        return view('fsec.show_attachment_fsec',[
            'establishment' => $establishment,
            'owner' => $owner,
            'files' =>  $files,
            'page_title' => 'Fire Safety Inspection Certificate' // use to set page title inside the panel
        ]);
    }

    public function print_fsec(Request $request){

        $evaluation = Evaluation::find($request->id);
        error_log($evaluation);
        return view('fsec.print_fsec',[
            'evaluation'=> $evaluation
        ]);
    }
}
