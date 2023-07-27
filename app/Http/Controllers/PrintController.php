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
        // $details = DB::table('establishments')
        // ->join('owners', 'establishments.owner_id', '=', 'owners.id')
        // ->join('payments', 'payments.establishment_id', '=', 'establishments.id')
        // ->where('payments.or_no', $orNo)
        // ->first();
        $inspection = Inspection::find($request->id);
        $establishment = $inspection->establishment;

        
        return view('establishments/fsic/print_fsic', [
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
        $inspection->status ='Printed';

        $establishment->inspection_is_expired = false;

        $inspection->save();
        $establishment->save();

        ActivityLogger::fsicLog($inspection->establishment->establishment_name,Activity::PrintInspection); 

        return redirect('/establishments'.'/'.$inspection->establishment->id.'/fsic');        
    }

    //Firedrill
    public function show_print_firedrill(Request $request){
        $firedrill = Firedrill::find($request->id);
        $receipt = $firedrill->receipt;
        $establishment = $firedrill->establishment;
        $owner = $establishment->owner;
        $personName =  $owner->person->first_name.' '.$owner->person->middle_name.' '.$owner->person->last_name;
        $company = $owner->corporate->corporate_name;
        
        // $representative = ($owner->person->last_name != null) ? $personName: $company;
        $representative = Helper::getRepresentativeName($establishment->owner_id);
        
        return view('establishments.firedrill.print_firedrill',[
            'estabId' => $establishment->id,
            'firedrillId' => $firedrill->id,
            'firedrill' => $firedrill,
            'controlNo' => $firedrill->control_no,
            'issuedOn' =>['day' => date('dS',strtotime($firedrill->issued_on)),'month'=> date('F',strtotime($firedrill->issued_on))],
            'validity' => $firedrill->validity_term.' '.$firedrill->year,
            'establishment' => $establishment->establishment_name,
            'dateMade' => $firedrill->date_made,
            'address' => $firedrill->establishment->address,
            'representative' => $representative,
            'payment' => ['orNo' => $receipt->or_no,'amountPaid'=>$receipt->amount, 'datePayment' => date('m/d/Y',strtotime($receipt->date_of_payment))]
        ]);
    }

    public function print_firedrill(Request $request){
        $firedrill = Firedrill::find($request->id);
        $establishment = Establishment::find($firedrill->establishment_id);
        $firedrill->user_id = auth()->user()->id;
        $firedrill->issued_on = date('Y-m-d');
        
        $firedrillCount = $establishment->firedrill_count_yearly + 1;

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

        ActivityLogger::firedrillLog($firedrill->establishment->establishment_name,Activity::PrintFiredrill);

        return redirect('/establishments'.'/'.$firedrill->establishment->id.'/firedrill');        
    }

    //FSEC
    public function show_print_fsec(Request $request)
    {
        $buildingPlan = BuildingPlan::find($request->id);

        return view('fsec.print_fsec',[
            'buildingPlan' => $buildingPlan
        ]);
    }

    public function show_print_fsecdisapprove(Request $request)
    {
        $buildingPlan = BuildingPlan::find($request->id);
        
        return view('fsec.print_fsec_disapprove',[
            'buildingPlan' => $buildingPlan
        ]);
    }

    public function show_print_fsecchecklist(Request $request){
        $buildingPlan = BuildingPlan::find($request->id);
        return view('fsec.print_fsec_checklist',[
            'buildingPlan' => $buildingPlan,
            'representative' => Helper::getRepresentativeName($buildingPlan->owner_id)
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

        $applicantName = explode(" ",Helper::getRepresentativeName($buildingPlan->owner_id));

        error_log(Helper::getRepresentativeName($buildingPlan->owner_id));

        ActivityLogger::buildingPlanLog($applicantName[0].' '.$applicantName[2],Activity::DisapporveBuildingPlan);

        return redirect('/fsecchecklist/print'.'/'.$buildingPlan->id);        
    }

    public function print_fsec(Request $request){
        $evaluation = new Evaluation();

        $buildingPlan = BuildingPlan::find($request->id);
        $buildingPlan->status = "APPROVED";

        $evaluation->evaluator = $request->evaluator;
        $evaluation->remarks = "APPROVED";
        $evaluation->building_plan_id = $buildingPlan->id;

        $evaluation->save();
        $buildingPlan->save();

        $applicantName = explode(" ",Helper::getRepresentativeName($buildingPlan->owner_id));
        ActivityLogger::buildingPlanLog($applicantName[0].' '.$applicantName[2],Activity::ApproveBuildingPlan);

        return redirect('/fsec'.'/'.$buildingPlan->id)->with(["mssg" => "Application Updated"]);        
    }
}
