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
        $buildingPlans = BuildingPlan::where('status','PENDING')->orderBy('series_no','desc')->get();
        return view('fsec.index',[
            'buildingPlans' => $buildingPlans
        ]);
    }

    public function create(){

        return view('fsec.createNew');
    }

    public function store(Request $request){
        // Instantiate Models
        $buildingPlan = new BuildingPlan();
        $owner = new Owner();
        $building = new Building();
        $receipt = new Receipt();

        // Add $owner Fields
        $owner->first_name = strtoupper($request->firstName);
        $owner->middle_name = strtoupper($request->middleName);
        $owner->last_name = strtoupper($request->lastName);
        $owner->suffix = strtoupper($request->nameSuffix);
        $owner->corporate_name = strtoupper($request->corporateName);
        $owner->save();

        // Add Building Fields

        //Add Receipt Fields

        // $payor =$owner != null ? $owner->first_name.' '.$owner->middle_name.' '.$owner->last_name : $owner->corporate_name;

        $receipt->or_no = $request->orNo;
        $receipt->receipt_for = "FSEC";
        $receipt->amount = $request->amountPaid;
        $receipt->date_of_payment = $request->dateOfPayment;
        $receipt->save();

        //Add Evaluation Fields
        $buildingPlan->project_title = strtoupper($request->projectTitle);
        $buildingPlan->name_of_building = strtoupper($request->buildingName);
        $buildingPlan->series_no = (sprintf("%04d",count(BuildingPlan::all()) + 1)).'-S\''.date('Y');
        $buildingPlan->bp_application_no = strtoupper($request->bpApplicationNo);
        $buildingPlan->bill_of_materials = strtoupper($request->billOfMaterials);
        $buildingPlan->date_received = $request->dateReceived;
        $buildingPlan->occupancy = strtoupper($request->occupancy);
        $buildingPlan->sub_type = strtoupper($request->subType);
        $buildingPlan->building_story = strtoupper($request->buildingStory);
        $buildingPlan->floor_area = strtoupper($request->floorArea);
        $buildingPlan->address = strtoupper($request->address);
        $buildingPlan->owner_id = $owner->id;
        $buildingPlan->receipt_id = $receipt->id;
        $buildingPlan->save();
        
        // ActivityLogger::buildingPlanLog($buildingPlan->getOwnerName(),Activity::AddBuildingPlan);

        $logMessage = "Added new application: ".$buildingPlan->getOwnerName();
        ActivityLogger::logActivity($logMessage,"FSEC");

        return redirect('/fsec'.'/'.$buildingPlan->id);
    }

    public function show(Request $request)
    {
        $buildingPlan = BuildingPlan::find($request->id);
        $evaluations = Evaluation::all()->where('building_plan_id',$buildingPlan->id)->sortDesc();

        return view('fsec.show',[
            'buildingPlan' => $buildingPlan,
            'evaluations' => $evaluations,
            'representative' => $buildingPlan->getOwnerName()
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

        //Update Evaluation Fields
        $buildingPlan->project_title = strtoupper($request->projectTitle);
        $buildingPlan->name_of_building = strtoupper($request->buildingName);
        $buildingPlan->bill_of_materials = strtoupper($request->billOfMaterials);
        $buildingPlan->occupancy = strtoupper($request->occupancy);
        $buildingPlan->sub_type = strtoupper($request->subType);
        $buildingPlan->building_story = strtoupper($request->buildingStory);
        $buildingPlan->floor_area = strtoupper($request->floorArea);
        $buildingPlan->address = strtoupper($request->address);
        
        //Update Receipt Fields
        $receipt->or_no = $request->orNo;
        $receipt->amount = $request->amountPaid;
        $receipt->date_of_payment = $request->dateOfPayment;
        
        //Only log if there is a change
        if($receipt->isDirty() || $buildingPlan->isDirty())
        {
            // $applicantName = explode(" ",$buildingPlan->getOwnerName());
            // ActivityLogger::buildingPlanLog($applicantName[0].' '.$applicantName[2],Activity::UpdateBuildingPlan);

            $logMessage = "Updated the application: ".$buildingPlan->getOwnerName();
            ActivityLogger::logActivity($logMessage,"FSEC");
        }

        $receipt->save();
        $buildingPlan->save();

        return redirect('/fsec'.'/'.$buildingPlan->id)->with(["mssg" => "Application Updated"]);
    }

    public function destory(Request $request){
        $buildingPlan = BuildingPlan::find($request->id);

        $buildingPlan->delete();

        ActivityLogger::buildingPlanLog($buildingPlan->getOwnerName(),Activity::DeleteBuildingPlan);

        return redirect('/fsec')->with(['toastMssg' => "Application Deleted"]);
    }

    public function release(Request $request){
        $buildingPlan = BuildingPlan::find($request->buildingPlanId);

        $buildingPlan->date_released = date('Y-m-d');

        $buildingPlan->save();

        $evaluations = Evaluation::all()->where('building_plan_id',$buildingPlan->id)->sortDesc();

        return view('fsec.show',[
            'buildingPlan' => $buildingPlan,
            'evaluations' => $evaluations,
            'representative' => $buildingPlan->getOwnerName()
        ]);
    }

    public function search(Request $request){

        // // Get the id in the search string
        // $search = explode("-", $request->search);
        // $buildPlanId = end($search);

        $buildingPlan = BuildingPlan::find($request->dataId);

        if($buildingPlan == null)
        {
            return redirect()->back()->with('searchQuery',strtoupper($request->search));
        }
        

        $evaluations = Evaluation::all()->where('building_plan_id',$buildingPlan->id)->sortDesc();

        return view('fsec.show',[
            'buildingPlan' => $buildingPlan,
            'evaluations' => $evaluations,
            'representative' => $buildingPlan->getOwnerName()
        ]);
    }

    public function pending(Request $request){

        $buildingPlans = BuildingPlan::where('status','PENDING')->orderBy('series_no','desc')->get();

        return view('fsec.pendingFsec',[
            'buildingPlans' => $buildingPlans
        ]);
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
