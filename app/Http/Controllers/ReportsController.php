<?php

namespace App\Http\Controllers;

use App\Models\BuildingPlan;
use App\Models\Evaluation;
use App\Models\Firedrill;
use App\Models\Inspection;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    //
    public function show_fsic(Request $request){
        $inspections = Inspection::whereYear('issued_on','=', $request->year)
        ->whereMonth('issued_on','=',$request->month)
        ->orderBy('issued_on')
        ->get();

        return view('reports.print.fsic',[
            'inspections' => $inspections,
            'date' =>['year' => $request->year,'month'=> date('F',strtotime('1975-'.$request->month.'-01'))]
        ]);
    }
    public function show_firedrill(Request $request){

        if($request->claimed == "true" && $request->claimed != null){
            $firedrills = Firedrill::whereYear('issued_on','=',$request->year)
            ->whereMonth('issued_on','=',$request->month)
            ->whereNull('date_claimed')
            ->get();
        }
        else{
            $firedrills = Firedrill::whereYear('issued_on','=',$request->year)
            ->whereMonth('issued_on','=',$request->month)
            ->whereNotNull('date_claimed')
            ->get();
        }

        return view('reports.print.firedrill',[
            'firedrills' => $firedrills,
            'date' =>['year' => $request->year,'month'=> date('F',strtotime('1975-'.$request->month.'-01'))]
        ]);
    }

    public function show_fsec(Request $request){
        
        $buildingPlans = BuildingPlan::join('evaluations','building_plans.id','=','evaluations.building_plan_id')
            ->join('buildings','building_plans.building_id','=','buildings.id')
            ->join('owners','building_plans.owner_id','=','owners.id')
            ->join('person','owners.person_id','=','person.id')
            ->join('corporates','owners.corporate_id','=','corporates.id')
            ->select()
            ->where('evaluations.remarks','APPROVED')
            ->whereMonth('evaluations.created_at',01)
            ->whereYear('evaluations.created_at',2022)
            ->get();

        $evaluations = Evaluation::where('remarks','APPROVED')
        ->whereMonth('evaluations.created_at',$request->month)
        ->whereYear('evaluations.created_at',$request->year)
        ->get();

        return view('reports.print.fsec',['buildingPlans' => $buildingPlans,'evaluations'=> $evaluations]);
    }

}