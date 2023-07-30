<?php

namespace App\Http\Controllers;

use App\Models\Inspection;
use Illuminate\Http\Request;

class ExpiredController extends Controller
{
    //
    public function inspections(Request $request){
        if(date('Y-m-d',strtotime($request->dateFrom)) > date('Y-m-d',strtotime($request->dateTo)))
        {   
            $errorMssg = "The selected date range is invalid.";
            return redirect()->back()->with('toastMssg',$errorMssg);
        }

        // If dateRange is null
        if($request->dateFrom == null && $request->dateTo == null)
        {
            $dateToday = date('Y-m-d');
            $inspections = Inspection::where('expiry_date',$dateToday)->orderBy('expiry_date')->get();
            return view('expiredList.inpsection',[
                'expired_inspections' => $inspections,
                'dateRange' => [$request->dateFrom,$request->dateTo],
                'dateQuery' => date('Y-m-d')
            ]);
        }

        //With date range 

        $dateFrom = date('Y-m-d',strtotime($request->dateFrom));
        $dateTo = date('Y-m-d',strtotime($request->dateTo));

        //To include the dateTo 
        $dateTo = $dateTo.' 23:59:59';

        $inspections = Inspection::whereBetween('expiry_date',[$dateFrom,$dateTo])->orderBy('expiry_date')->get();

        return view('expiredList.inpsection',[
            'expired_inspections' => $inspections,
            'dateRange' => [$request->dateFrom,$request->dateTo]
        ]);
    }

    public function firedrills(){

        return view('expiredList.firedrill',[

        ]);
    }
}
