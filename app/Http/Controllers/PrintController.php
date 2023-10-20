<?php

namespace App\Http\Controllers;

use App\Models\BuildingPlan;
use App\Models\Establishment;
use App\Models\Evaluation;
use App\Models\Firedrill;
use App\Models\Inspection;
use Illuminate\Http\Request;

class PrintController extends Controller
{
    //Inspection
    public function show_print_fsic(Request $request){
        $inspection = Inspection::find($request->id);
        $establishment = $inspection->establishment;
        return view('printables.fsic', [
            'inspection' => $inspection,
            'establishment' => $establishment
        ]);
        
    }
    
    public function print_fsic(Request $request){
        $inspection = Inspection::find($request->id);
        $establishment = Establishment::find($inspection->establishment->id);
        
        $inspection->expiry_date = date("Y-m-d",strtotime("+1 year"));
        $inspection->issued_on = date("Y-m-d");
        $inspection->user_id = auth()->user()->id;
        $inspection->others_descrpt = $request->othersDescrpt;
        $inspection->valid_for_descrpt = $request->validForDescrpt1;
        $inspection->valid_for_descrpt2 = $request->validForDescrpt2;
        $inspection->status ='Printed';

        $establishment->inspection_is_expired = false;

        $inspection->save();
        $establishment->save();

        $logMessage = "Issued a Fire Safety Inspection Certificate: FSIC.NO {$inspection->fsic_no} to {$establishment->establishment_name}";
        ActivityLogger::logActivity($logMessage,'FSIC');
        // ActivityLogger::fsicLog($inspection->establishment->establishment_name,Activity::PrintInspection); 

        return redirect('/establishments'.'/'.$inspection->establishment->id.'/fsic');        
    }

    //Firedrill
    public function show_print_firedrill(Request $request){
        $firedrill = Firedrill::find($request->id);
        $establishment = $firedrill->establishment;
        $owner = $establishment->owner;
        // $representative = ($owner->person->last_name != null) ? $personName: $company;

        $representative = $establishment->getOwnerName();
        
        $firedrillsByYear = (Firedrill::where('year',date('Y')));
        $newControlNo = date('Y').'-CCFO-'.sprintf("%04d",$firedrillsByYear->count() + 1);

        return view('printables.firedrill',[
            'firedrill' => $firedrill,
            'controlNo' => $newControlNo,
            'representative' => $representative,
            'establishment' => $establishment
        ]);
    }

    public function print_firedrill(Request $request){
        $firedrill = Firedrill::find($request->id);
        $establishment = Establishment::find($firedrill->establishment_id);

        // If firedrill is reprinted
        if($request->action == "reprint"){
            $logMessage = "Reprinted the Firedrill Certificate: CONTROL.NO {$firedrill->control_no} to {$establishment->establishment_name}";
            ActivityLogger::logActivity($logMessage,'FIREDRILL');
            return redirect('/establishments'.'/'.$firedrill->establishment->id.'/firedrill');        
        }

        $firedrill->user_id = auth()->user()->id;
        $firedrill->issued_on = date('Y-m-d');
        
        $firedrillCount = $establishment->firedrill_count_yearly + 1;

        $firedrill->control_no = $request->newControlNo;

        if($establishment->firedrill_type == 'QUARTERLY'){

            if($firedrillCount >= 1 && date('m') <= 3)
            {
                // if there is 1 firedrill in 1st quarter
                $establishment->firedrill_is_expired = false;
            }
            else if ($firedrillCount >= 2 && date('m') <= 6)
            {
                // if there is 2 firedrill in 2nd quarter
                $establishment->firedrill_is_expired = false;
            }
            else if ($firedrillCount >= 3 && date('m') <= 9){
                // if there is 3 firedrill in 3rd quarter
                $establishment->firedrill_is_expired = false;
            }
            else if ($firedrillCount >= 3 && date('m') <= 12) {
                // if there is 4 firedrill in 4th quarter
                $establishment->firedrill_is_expired = false;
            }
        }
        else
        {
            if($firedrillCount >= 1 && date('m') <= 6)
            {
                // if there is 1 firedrill in 1st quarter
                $establishment->firedrill_is_expired = false;
            }
            else if ($firedrillCount >= 2 && date('m') <= 12)
            {
                // if there is 2 firedrill in 2nd quarter
                $establishment->firedrill_is_expired = false;
            }
        }

        $establishment->firedrill_count_yearly = $firedrillCount;

        $establishment->save();
        $firedrill->save();

        $logMessage = "Issued a Firedrill Certificate: CONTROL.NO {$firedrill->control_no} to {$establishment->establishment_name}";
        ActivityLogger::logActivity($logMessage,'FIREDRILL');

        // ActivityLogger::firedrillLog($firedrill->establishment->establishment_name,Activity::PrintFiredrill);

        return redirect('/establishments'.'/'.$firedrill->establishment->id.'/firedrill');        
    }

    //FSEC
    public function show_print_fsec(Request $request)
    {
        $buildingPlan = BuildingPlan::find($request->id);

        if($buildingPlan->date_approved != null && !$request->viewOnly) {
            return back();
        }

        return view('printables.fsec',[
            'buildingPlan' => $buildingPlan
        ]);
    }

    public function show_print_fsecdisapprove(Request $request)
    {
        $buildingPlan = BuildingPlan::find($request->id);
        
        return view('printables.fsec_disapprove',[
            'buildingPlan' => $buildingPlan
        ]);
    }

    public function show_print_fsecchecklist(Request $request){
        $buildingPlan = BuildingPlan::find($request->id);
        return view('printables.fsec_checklist',[
            'buildingPlan' => $buildingPlan,
            'representative' => $buildingPlan->getOwnerName()
        ]);
    }

    public function print_fsecdisapprove(Request $request){
        $evaluation = new Evaluation();

        $buildingPlan = BuildingPlan::find($request->id);
        $buildingPlan->status = "DISAPPROVED";

        $evaluation->evaluator = $request->evaluator;
        $evaluation->remarks = "DISAPPROVED";
        $evaluation->building_plan_id = $buildingPlan->id;

        $evaluation->save();
        $buildingPlan->save();

        $applicantName = explode(" ",$buildingPlan->getOwnerName());

        error_log($buildingPlan->getOwnerName());

        // ActivityLogger::buildingPlanLog($applicantName[0].' '.$applicantName[2],Activity::DisapporveBuildingPlan);
        ActivityLogger::buildingPlanLog($buildingPlan->getOwnerName(),Activity::DisapporveBuildingPlan);


        return redirect('/fsecchecklist/print'.'/'.$buildingPlan->id);        
    }

    public function print_fsec(Request $request){
        $evaluation = new Evaluation();

        $buildingPlan = BuildingPlan::find($request->id);
        $buildingPlan->status = "APPROVED";

        $evaluation->evaluator = $request->evaluator;
        $evaluation->remarks = "APPROVED";
        $evaluation->building_plan_id = $buildingPlan->id;

        $buildingPlan->date_approved = date('Y-m-d',$evaluation->created_at);


        $evaluation->save();
        $buildingPlan->save();

        // $applicantName = explode(" ",$buildingPlan->getOwnerName());
        // ActivityLogger::buildingPlanLog($applicantName[0].' '.$applicantName[2],Activity::ApproveBuildingPlan);
        // ActivityLogger::buildingPlanLog($buildingPlan->getOwnerName(),Activity::ApproveBuildingPlan);

        $logMessage = "Approved the Building Plan Application: ".$buildingPlan->getOwnerName();
        ActivityLogger::logActivity($logMessage,'FSEC');

        return redirect('/fsec'.'/'.$buildingPlan->id)->with(["mssg" => "Application Updated"]);        
    }
}
