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
        
        if($request->selfReport){
            $inspections = Inspection::whereBetween('issued_on',[date('Y-m-d',strtotime($request->dateFrom)),date('Y-m-d',strtotime($request->dateTo))])
            ->where('user_id',auth()->user()->id)
            ->orderBy('issued_on')
            ->get();

            $inspectionsSm = Inspection::join('establishments','establishments.id','=','inspections.establishment_id')
            ->select('establishments.substation','establishments.id','inspections.fsic_no','inspections.registration_status')
            ->where('user_id',auth()->user()->id)
            ->whereNot('registration_status','NEW')
            ->whereBetween('issued_on',[date('Y-m-d',strtotime($request->dateFrom)),date('Y-m-d',strtotime($request->dateTo))])->get();
        }
        else{
            $inspections = Inspection::whereBetween('issued_on',[date('Y-m-d',strtotime($request->dateFrom)),date('Y-m-d',strtotime($request->dateTo))])
            ->orderBy('issued_on')
            ->get();

            $inspectionsSm = Inspection::join('establishments','establishments.id','=','inspections.establishment_id')
            ->select('establishments.substation','establishments.id','inspections.fsic_no','inspections.registration_status')
            ->whereNot('registration_status','NEW')
            ->whereBetween('issued_on',[date('Y-m-d',strtotime($request->dateFrom)),date('Y-m-d',strtotime($request->dateTo))])->get();
        }

        // GET INSPECTIONS EXCEPT FOR CBP
        $inspectionsSubstation = $inspectionsSm->where('substation','!=','CBP');

        // GROUP SUBSTATIONS
        // $fsicIssuedSubstation = $inspectionsSubstation->groupBy('substation');
        $fsicIssuedSubstation = $inspectionsSm->groupBy('substation');

        // GET REG_STAT NEW INSPTECTIONS
        $inspectionsNew = Inspection::whereBetween('issued_on',[date('Y-m-d',strtotime($request->dateFrom)),date('Y-m-d',strtotime($request->dateTo))])
            ->where('registration_status','NEW')->count();

        // GET REG_STAT OCCUPANCY INSPTECTIONS
        $inspectionsOccupancy = $inspectionsSm->where('registration_status','OCCUPANCY');

        // GET CBP SUBSTATIONS
        $inspectionsCBP = $fsicIssuedSubstation->where('substation','CBP');

        // TOTALS
        $totalSubstation = 0;
        foreach($fsicIssuedSubstation as $substation){
            $totalSubstation += count($substation);
        }
        
        $totalNew = $inspectionsNew;
        $totalCBP = count($inspectionsCBP);
        $totalOccupancy = count($inspectionsOccupancy);
        $totalSubstation = count($inspectionsSubstation);

        $totalGrand = $totalNew + $totalCBP + $totalSubstation;

        $fsicIssued = [
            'substations' => $fsicIssuedSubstation,
            'totalCBP' => $totalCBP,
            'totalNew' => $totalNew,
            'totalSubstation' => $totalSubstation,
            'totalGrand' => $totalGrand,
            'totalOccupancy' => $totalOccupancy,
            'totalSubstation' => $totalSubstation
        ];

        return view('reports.fsicReportsNew',[
            'fsicIssued' => $fsicIssued,
            'inspections' => $inspections,
            'selfReport' => $selfReport,
            'dateRange' => ['from' => $request->dateFrom,'to' => $request->dateTo],
            'substationsCount' => Inspection::get_inspections_by_substation_count(['from' => $request->dateFrom,'to' => $request->dateTo])
        ]);
    }

}
