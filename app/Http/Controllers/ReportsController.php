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
        $selfReport = $request->selfReport ? true : false;

        if($request->selfReport){
            $inspections = Inspection::whereYear('issued_on','=', $request->year)
            ->whereMonth('issued_on','=',$request->month)
            ->where('user_id',auth()->user()->id)
            ->orderBy('issued_on')
            ->get();
        }
        else{
            $inspections = Inspection::whereYear('issued_on','=', $request->year)
            ->whereMonth('issued_on','=',$request->month)
            ->orderBy('issued_on')
            ->get();
        }


        return view('reports.print.fsic',[
            'inspections' => $inspections,
            'date' =>['year' => $request->year, 'month'=> date('F',strtotime('1975-'.$request->month.'-01')), 'monthInt' => $request->month],
            'selfReport' => $selfReport
        ]);
    }
    public function show_firedrill(Request $request){
        $selfReport = $request->selfReport ? true : false;

        if($request->unclaimed){

            if($request->selfReport){
                $firedrills = Firedrill::whereYear('issued_on','=',$request->year)
                ->whereMonth('issued_on','=',$request->month)
                ->where('user_id',auth()->user()->id)
                ->whereNull('date_claimed')
                ->get();
            }
            else{
                $firedrills = Firedrill::whereYear('issued_on','=',$request->year)
                ->whereMonth('issued_on','=',$request->month)
                ->whereNull('date_claimed')
                ->get();
            }
        }
        else{
            if($request->selfReport){
                $firedrills = Firedrill::whereYear('issued_on','=',$request->year)
                ->whereMonth('issued_on','=',$request->month)
                ->where('user_id',auth()->user()->id)
                ->whereNotNull('date_claimed')
                ->get();
            }
            else{
                $firedrills = Firedrill::whereYear('issued_on','=',$request->year)
                ->whereMonth('issued_on','=',$request->month)
                ->whereNotNull('date_claimed')
                ->get();
            }
        }

        $unclaimed = $request->unclaimed ? true : false;

        return view('reports.print.firedrill',[
            'firedrills' => $firedrills,
            'date' =>['year' => $request->year,'month'=> date('F',strtotime('1975-'.$request->month.'-01')),'monthInt' => $request->month],
            'selfReport' => $selfReport,
            'unclaimed' => $unclaimed
        ]);
    }

    public function show_fsec(Request $request){
        $selfReport = $request->selfReport ? true : false;
        
        // $buildingPlans = BuildingPlan::join('evaluations','building_plans.id','=','evaluations.building_plan_id')
        //     ->join('buildings','building_plans.building_id','=','buildings.id')
        //     ->join('owners','building_plans.owner_id','=','owners.id')
        //     ->join('person','owners.person_id','=','person.id')
        //     ->join('corporates','owners.corporate_id','=','corporates.id')
        //     ->select()
        //     ->where('evaluations.remarks','APPROVED')
        //     ->whereMonth('evaluations.created_at',01)
        //     ->whereYear('evaluations.created_at',2022)
        //     ->get();

        if($selfReport){
            $evaluations = Evaluation::where('remarks','APPROVED')
            ->whereMonth('evaluations.created_at',$request->month)
            ->whereYear('evaluations.created_at',$request->year)
            ->where('evaluator',auth()->user()->name)
            ->get();
        }
        else{
            $evaluations = Evaluation::where('remarks','APPROVED')
            ->whereMonth('evaluations.created_at',$request->month)
            ->whereYear('evaluations.created_at',$request->year)
            ->get();
        }

        return view('reports.print.fsec',[
            'evaluations'=> $evaluations,
            'date' =>['year' => $request->year,'month'=> date('F',strtotime('1975-'.$request->month.'-01')),'monthInt' => $request->month],
            'selfReport' => $selfReport
        ]);
    }

}