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
use Illuminate\Support\Facades\Storage;

class FsecController extends Controller
{
    public function index(Request $request){
        $buildingPlans = BuildingPlan::where('status','PENDING')->orderBy('series_no','desc')->get();
        return view('fsec.index',[
            'buildingPlans' => $buildingPlans
        ]);
    }

    public function create(){

        return view('fsec.create');
    }

    public function store(Request $request){
        // Instantiate Models
        $buildingPlan = new BuildingPlan();
        $owner = new Owner();
        $receipt = new Receipt();
        
        
        //If name and corporate is emptpy 
        if(($request->firstName == null && $request->lastName == null) && $request->corporateName == null) {
            return back()->with('toastMssg',"Neither Name or Corporate must not be empty");
        }

        // check if owner exist
        $owner = Owner::where('first_name',strtoupper($request->firstName))
        ->where('middle_name',strtoupper($request->middleName))
        ->where('last_name',strtoupper($request->lastName))
        ->where('corporate_name',strtoupper($request->corporateName))
        ->first();

        // create owner if it doesn not exist
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
        //Add Receipt Fields
        $receipt->or_no = $request->orNo;
        $receipt->receipt_for = "FSEC";
        $receipt->amount = $request->amountPaid;
        $receipt->date_of_payment = $request->dateOfPayment;
        $receipt->save();

        //Add Evaluation Fields
        $buildingPlan->project_title = strtoupper($request->projectTitle);
        $buildingPlan->name_of_building = strtoupper($request->buildingName);
        $buildingPlan->series_no = (sprintf("%04d",count(BuildingPlan::all()) + 1)).'-S\''.date('Y');
        // $buildingPlan->series_no =  strtoupper($request->seriesNo);
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
        $evaluations = Evaluation::where('building_plan_id',$buildingPlan->id)
        ->where('remarks','DISAPPROVED')
        ->get()
        ->sortDesc();

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
        //If name and corporate is emptpy 
        if(($request->firstName == null && $request->lastName == null) && $request->corporateName == null) {
            return back()->with('toastMssg',"Both Name or Corporate must not be empty");
        }
        
        $buildingPlan = BuildingPlan::find($request->id);
        $receipt = $buildingPlan->receipt;
        $owner = $buildingPlan->owner;

        // Update Owner Fields
        $owner->first_name = strtoupper($request->firstName);
        $owner->middle_name =strtoupper($request->middleName) ;
        $owner->last_name = strtoupper($request->lastName);
        $owner->suffix = strtoupper($request->nameSuffix);
        $owner->contact_no = $request->contactNo;
        $owner->corporate_name = strtoupper($request->corporateName);

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
        if($receipt->isDirty() || $buildingPlan->isDirty() || $owner->isDirty())
        {
            // $applicantName = explode(" ",$buildingPlan->getOwnerName());
            // ActivityLogger::buildingPlanLog($applicantName[0].' '.$applicantName[2],Activity::UpdateBuildingPlan);

            $logMessage = "Updated the Building Plan Application: ".$buildingPlan->getOwnerName();
            ActivityLogger::logActivity($logMessage,"FSEC");
        }

        $receipt->save();
        $buildingPlan->save();
        $owner->save();


        return redirect('/fsec'.'/'.$buildingPlan->id)->with(["mssg" => "Application Updated"]);
    }

    public function destroy(Request $request){
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

        $logMessage = "Released the Evaluation Certificate: to {$buildingPlan->getOwnerName()}";
        ActivityLogger::logActivity($logMessage,'FSEC');

        return redirect("fsec/{$buildingPlan->id}");
    }

    public function search(Request $request){

        $buildingPlan = BuildingPlan::find($request->dataId);

        if($buildingPlan == null)
        {
            return redirect()->back()->with('searchQuery',strtoupper($request->search));
        }
        
        return redirect("fsec/{$buildingPlan->id}");
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

    public function uploadDisapproval(Request $request){
        $for = $request->for;

        $file = $request->file('fileUpload')[0];
        $evaluation = Evaluation::find($request->evaluationId);

        $fileName = "_{$request->evaluationId}.{$file->extension()}";

        if($for == "disapproval"){
            $disapprove_print_path = "evaluations/disapproval/$fileName";
            $evaluation->disapprove_print_path = $disapprove_print_path;
            $evaluation->save();
        }else if($for == "checklist"){
            $checklist_print_path = "evaluations/checklist/$fileName";
            $evaluation->checklist_print_path = $checklist_print_path;
            $evaluation->save();
        }

        Storage::putFileAs("evaluations/$for", $file, $fileName);

        return redirect("/fsec/{$evaluation->building_plan_id}")->with(["mssg" => "File Uploaded"]);
    }

    public function downloadDisapproval(Request $request){
        $filename = "_".$request->id;
        $path = "evaluations/{$request->for}/{$filename}.pdf";
        $filenameD = $request->for == "disapproval" ? "disapproval_notice" : "checklist";
        // Return the file as a download
        return Storage::download($path,"{$filenameD}_{$request->id}.pdf");
    }
}
