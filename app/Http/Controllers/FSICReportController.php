<?php

namespace App\Http\Controllers;

use App\Models\Inspection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FSICReportController extends Controller
{
    //
    //
    // public function oldIndex(Request $request){
    //     $yearReports = DB::table('inspections')
    //     ->select(DB::raw('DISTINCT YEAR(issued_on) as year'))
    //     ->whereNotNull('issued_on')
    //     ->orderBy('year', 'desc')
    //     ->get();

    //     $monthReports = null;

    //     $reports = [];
    //     $selectedYear = null;
    //     $selectedMonth = null;
    //     $fsicIssuedSubstation = null;
    //     $substationTotalCountInspection = 0;
    //     $cbpInspection = 0;
    //     $issuedNew = 0;

    //     foreach($yearReports as $item){
    //         $yearlyReports = DB::table('inspections')
    //         ->select(DB::raw('DISTINCT MONTH(issued_on) as month'))
    //         ->whereNotNull('issued_on')
    //         ->whereYear('issued_on', '=', $item->year)
    //         ->orderBy('month', 'asc')
    //         ->get();

    //         $reports[$item->year] = $yearlyReports;
    //     }

    //     if(count($yearReports) != 0){

    //         $selectedYear = $request->selectedYear ? $request->selectedYear :$yearReports->first()->year;
            
    //         $monthReports = DB::table('inspections')
    //         ->select(DB::raw('DISTINCT MONTH(issued_on) as month'))
    //         ->whereNotNull('issued_on')
    //         ->whereYear('issued_on', '=',$selectedYear)
    //         ->orderBy('month', 'asc')
    //         ->get();

    //         $selectedMonth = $request->selectedMonth ? $request->selectedMonth : $monthReports->first()->month; 

    //         $fsicIssuedSubstation = [
    //             'Guadalupe' => FSICHelper::getIssuedFSICCount('GUADALUPE',$selectedYear,$selectedMonth),
    //             'Labangon' => FSICHelper::getIssuedFSICCount('LABANGON',$selectedYear,$selectedMonth),
    //             'Lahug' => FSICHelper::getIssuedFSICCount('LAHUG',$selectedYear,$selectedMonth),
    //             'Mabolo' => FSICHelper::getIssuedFSICCount('MABOLO',$selectedYear,$selectedMonth),
    //             'Pahina Central' => FSICHelper::getIssuedFSICCount('PAHINA CENTRAL',$selectedYear,$selectedMonth),
    //             'Pardo' => FSICHelper::getIssuedFSICCount('PARDO',$selectedYear,$selectedMonth),
    //             'Pari-an' => FSICHelper::getIssuedFSICCount('PARI-AN',$selectedYear,$selectedMonth),
    //             'San Nicolas' => FSICHelper::getIssuedFSICCount('SAN NICOLAS',$selectedYear,$selectedMonth),
    //             'Talamban' => FSICHelper::getIssuedFSICCount('TALAMBAN',$selectedYear,$selectedMonth)
    //         ];
    //         $substationTotalCountInspection = 0;
    //         $cbpInspection = FSICHelper::getIssuedFSICCount('CBP',$selectedYear,$selectedMonth);

    //         foreach($fsicIssuedSubstation as $key => $value){
    //             $substationTotalCountInspection += $value;
    //         }
    //         $issuedNew = FSICHelper::getIssuedNewByMonthNFSIC($selectedYear,$selectedMonth);
    //     }

    //     $fsicIssued = [
    //         'issuedBySubstation' => $fsicIssuedSubstation,
    //         'CBP' => $cbpInspection,
    //         'new' => $issuedNew,
    //         'totalSubstation' => $substationTotalCountInspection,
    //         'totalGrand' => $cbpInspection + $substationTotalCountInspection + $issuedNew
    //     ];

        
    //     return view('reports.fsicReports',[
    //         'yearReports' => $yearReports,
    //         'monthReports' => $monthReports,
    //         'fsicIssued' =>$fsicIssued,
    //         'reports' => $reports,
    //         'selectedReports' => ['month' =>$selectedMonth, 'year' => $selectedYear]
    //     ]);
    // }

    public function index(Request $request){
        if(date('Y-m-d',strtotime($request->dateFrom)) > date('Y-m-d',strtotime($request->dateTo)))
        {   
            $errorMssg = "The selected date range is invalid.";
            return redirect()->back()->with('toastMssg',$errorMssg);
        }
        
        $inspections = Inspection::join('establishments','establishments.id','=','inspections.establishment_id')
        ->select('establishments.substation','establishments.id','inspections.fsic_no','inspections.registration_status')
        ->whereBetween('issued_on',[date('Y-m-d',strtotime($request->dateFrom)),date('Y-m-d',strtotime($request->dateTo))])->get();

        // GET INSPECTIONS EXCEPT FOR CBP
        $inspectionsSubstation = $inspections->where('substation','!=','CBP');

        // GROUP SUBSTATIONS
        $fsicIssuedSubstation = $inspectionsSubstation->groupBy('substation');

        // GET REG_STAT NEW INSPTECTIONS
        $inspectionsNew = $inspections->where('registration_status','NEW');

        // GET CBP SUBSTATIONS
        $inspectionsCBP = $inspections->where('substation','CBP');

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
            'totalGrand' => $totalCBP + $totalSubstation 
        ];

        return view('reports.fsicReports',[
            'fsicIssued' => $fsicIssued,
            'dateRange' => ['from' => $request->dateFrom,'to' => $request->dateTo]
        ]);
    }

    // public function getFSICReport(Request $request){
    //     if($request->year != null)
    //     {
    //         $issuedMonth = [
    //             'Guadalupe' => Helper::getIssuedFSIC('GUADALUPE',$request->year,$request->month),
    //             'Labangon' => Helper::getIssuedFSIC('LABANGON',$request->year,$request->month),
    //             'Lahug' => Helper::getIssuedFSIC('LAHUG',$request->year,$request->month),
    //             'Mabolo' => Helper::getIssuedFSIC('MABOLO',$request->year,$request->month),
    //             'Pahina Central' => Helper::getIssuedFSIC('PAHINA CENTRAL',$request->year,$request->month),
    //             'Pardo' => Helper::getIssuedFSIC('PARDO',$request->year,$request->month),
    //             'Pari-an' => Helper::getIssuedFSIC('PARI-AN',$request->year,$request->month),
    //             'San Nicolas' => Helper::getIssuedFSIC('SAN NICOLAS',$request->year,$request->month),
    //             'Talamban' => Helper::getIssuedFSIC('TALAMBAN',$request->year,$request->month),
    //             'CBP' => Helper::getIssuedFSIC('CBP',$request->year,$request->month)
    //         ];
    //         $issuedInMonthNew = Helper::getIssuedNewByMonthNFSIC($request->year,$request->month);
    //         $issuedInMonthAll = Helper::getIssuedAllByMonthFSIC($request->year,$request->month);
    
    //         return response()->json([
    //             'status' => 'success',
    //             'data' => ['substation' => $issuedMonth,'issuedInMonthNew' => $issuedInMonthNew,'issuedInMonthAll' => $issuedInMonthAll]
    //         ]);
    //     }

    //     return response()->json([
    //         'status' => 'cannot fetch resource',
    //         'data' => 'no data'
    //     ]);
    // }
}
