<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FSECReportController extends Controller
{
    public function index(Request $request){
        if(date('Y-m-d',strtotime($request->dateFrom)) > date('Y-m-d',strtotime($request->dateTo)))
        {   
            $errorMssg = "The selected date range is invalid.";
            return redirect()->back()->with('toastMssg',$errorMssg);
        }

        $selfReport = $request->selfReport ? true : false;
        if($selfReport){
            $evaluations = Evaluation::where('remarks','APPROVED')
            ->whereBetween('evaluations.created_at',[$request->dateFrom.' 00:00:00',$request->dateTo.' 23:59:59'])
            ->where('evaluator',auth()->user()->personnel->first_name.' '.auth()->user()->personnel->last_name)
            ->get();
        }
        else{
            $evaluations = Evaluation::where('remarks','APPROVED')
            ->whereBetween('evaluations.created_at',[$request->dateFrom.' 00:00:00',$request->dateTo.' 23:59:59'])
            ->get();
        }
        
        return view('reports.fsecReportsNew',[
            'evaluations'=> $evaluations,
            'date' =>['year' => $request->year,'month'=> date('F',strtotime('1975-'.$request->month.'-01')),'monthInt' => $request->month],
            'dateRange' => ['from' => $request->dateFrom,'to' => $request->dateTo],
            'selfReport' => $selfReport
        ]);
        
    }
}
