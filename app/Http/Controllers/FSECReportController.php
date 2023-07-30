<?php

namespace App\Http\Controllers;

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
        
        return view('reports.fsecReports',[
            'dateRange' => ['from' => $request->dateFrom,'to' => $request->dateTo]
        ]);
        
    }
}
