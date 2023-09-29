<?php

namespace App\Http\Controllers;

use App\Models\Firedrill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FiredrillReportController extends Controller
{
    public function index(Request $request){
        if(date('Y-m-d',strtotime($request->dateFrom)) > date('Y-m-d',strtotime($request->dateTo)))
        {   
            $errorMssg = "The selected date range is invalid.";
            return redirect()->back()->with('toastMssg',$errorMssg);
        }

        $selfReport = $request->selfReport ? true : false;
        $unclaimed = $request->unclaimed ? true : false;

        // GET ALL FIREDRILLS BASED ON DATE RANGE
        $firedrills = Firedrill::join('establishments','establishments.id','=','firedrills.establishment_id')
        ->select('establishments.substation','firedrills.date_claimed','firedrills.issued_on')
        ->whereBetween('issued_on',[date('Y-m-d',strtotime($request->dateFrom)),date('Y-m-d',strtotime($request->dateTo))])->get();

        // GET FIREDRILLS SUBSTATION
        $firedrillSubstation = $firedrills->where('substation','!=','CBP');

        // GROUP SUBSTATIONS
        // $firedrillIssuedSubstation = $firedrillSubstation->groupBy('substation');
        $firedrillIssuedSubstation = $firedrills->groupBy('substation');

        // GET CBP SUBSTATIONS
        $firedrillCBP = $firedrills->where('substation','CBP');

        // GET UNCLAIMED
        $firedrillUnclaimed = $firedrills->whereNull('date_claimed')->whereNotNull('issued_on');

        // TOTALS
        $totalSubstation = 0;
        foreach($firedrillIssuedSubstation as $substation){
            $totalSubstation += count($substation);
        }

        $totalCBP = count($firedrillCBP);

        $firedrillIssued = [
            'substations' => $firedrillIssuedSubstation,
            'totalCBP' => $totalCBP,
            'totalSubstation' => $totalSubstation,
            'totalGrand' => $totalSubstation, 
            'totalUnclaimed' => count($firedrillUnclaimed)
        ];

        if($request->unclaimed){

            if($request->selfReport){
                $firedrills = Firedrill::whereBetween('issued_on',[date('Y-m-d',strtotime($request->dateFrom)),date('Y-m-d',strtotime($request->dateTo))])
                ->where('user_id',auth()->user()->id)
                ->whereNull('date_claimed')
                ->get();
            }
            else{
                $firedrills = Firedrill::whereBetween('issued_on',[date('Y-m-d',strtotime($request->dateFrom)),date('Y-m-d',strtotime($request->dateTo))])
                ->whereNull('date_claimed')
                ->get();
            }
        }
        else{
            if($request->selfReport){
                $firedrills = Firedrill::whereBetween('issued_on',[date('Y-m-d',strtotime($request->dateFrom)),date('Y-m-d',strtotime($request->dateTo))])
                ->where('user_id',auth()->user()->id)
                ->whereNotNull('date_claimed')
                ->get();
            }
            else{
                $firedrills = Firedrill::whereBetween('issued_on',[date('Y-m-d',strtotime($request->dateFrom)),date('Y-m-d',strtotime($request->dateTo))])
                ->whereNotNull('date_claimed')
                ->get();
            }
        }

        return view('reports.firedrillReportsNew',[
            'dateRange' => ['from' => $request->dateFrom, 'to' => $request->dateTo],
            'firedrillIssued' => $firedrillIssued,
            'isUnclaimed' => $request->unclaimed,
            'debug' => $firedrillUnclaimed,
            'selfReport' => $selfReport,
            'unclaimed' => $unclaimed,
            'firedrills' => $firedrills
        ]);
    }
}
