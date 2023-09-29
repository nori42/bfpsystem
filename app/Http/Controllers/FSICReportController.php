<?php

namespace App\Http\Controllers;

use App\Models\Inspection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FSICReportController extends Controller
{
    public function index(Request $request){
        if(date('Y-m-d',strtotime($request->dateFrom)) > date('Y-m-d',strtotime($request->dateTo)))
        {   
            $errorMssg = "The selected date range is invalid.";
            return redirect()->back()->with('toastMssg',$errorMssg);
        }

        $selfReport = $request->selfReport ? true : false;
        
        // $inspections = Inspection::join('establishments','establishments.id','=','inspections.establishment_id')
        // ->select('establishments.substation','establishments.id','inspections.fsic_no','inspections.registration_status')
        // ->whereBetween('issued_on',[date('Y-m-d',strtotime($request->dateFrom)),date('Y-m-d',strtotime($request->dateTo))])->get();

        if($request->selfReport){
            $inspections = Inspection::whereBetween('issued_on',[date('Y-m-d',strtotime($request->dateFrom)),date('Y-m-d',strtotime($request->dateTo))])
            ->where('user_id',auth()->user()->id)
            ->orderBy('issued_on')
            ->get();

            $inspectionsSm = Inspection::join('establishments','establishments.id','=','inspections.establishment_id')
            ->select('establishments.substation','establishments.id','inspections.fsic_no','inspections.registration_status')
            ->where('user_id',auth()->user()->id)
            ->whereBetween('issued_on',[date('Y-m-d',strtotime($request->dateFrom)),date('Y-m-d',strtotime($request->dateTo))])->get();
        }
        else{
            $inspections = Inspection::whereBetween('issued_on',[date('Y-m-d',strtotime($request->dateFrom)),date('Y-m-d',strtotime($request->dateTo))])
            ->orderBy('issued_on')
            ->get();

            $inspectionsSm = Inspection::join('establishments','establishments.id','=','inspections.establishment_id')
            ->select('establishments.substation','establishments.id','inspections.fsic_no','inspections.registration_status')
            ->whereBetween('issued_on',[date('Y-m-d',strtotime($request->dateFrom)),date('Y-m-d',strtotime($request->dateTo))])->get();
        }

        // GET INSPECTIONS EXCEPT FOR CBP
        $inspectionsSubstation = $inspections->where('substation','!=','CBP');

        // GROUP SUBSTATIONS
        // $fsicIssuedSubstation = $inspectionsSubstation->groupBy('substation');
        $fsicIssuedSubstation = $inspectionsSm->groupBy('substation');

        // GET REG_STAT NEW INSPTECTIONS
        $inspectionsNew = $inspectionsSm->where('registration_status','NEW');

        // GET CBP SUBSTATIONS
        $inspectionsCBP = $inspectionsSm->where('substation','CBP');

        // TOTALS
        $totalSubstation = 0;
        foreach($fsicIssuedSubstation as $substation){
            $totalSubstation += count($substation);
        }

        $totalNew = count($inspectionsNew);
        $totalCBP = count($inspectionsCBP);

        $fsicIssued = [
            'substations' => $fsicIssuedSubstation,
            'totalCBP' => $totalCBP,
            'totalNew' => $totalNew,
            'totalSubstation' => $totalSubstation,
            'totalGrand' => $totalSubstation 
        ];

        return view('reports.fsicReportsNew',[
            'fsicIssued' => $fsicIssued,
            'inspections' => $inspections,
            'selfReport' => $selfReport,
            'dateRange' => ['from' => $request->dateFrom,'to' => $request->dateTo]
        ]);
    }

}
