<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FSICReportController extends Controller
{
    //
    //
    public function index(){
        $yearReports = DB::table('inspections')
        ->select(DB::raw('DISTINCT YEAR(issued_on) as year'))
        ->whereNotNull('issued_on')
        ->orderBy('year', 'desc')
        ->get();
        
        $reports = [];

        foreach($yearReports as $item){
            $yearlyReports = DB::table('inspections')
            ->select(DB::raw('DISTINCT MONTH(issued_on) as month'))
            ->whereNotNull('issued_on')
            ->whereYear('issued_on', '=', $item->year)
            ->orderBy('month', 'asc')
            ->get();

            $reports[$item->year] = $yearlyReports;
        }

        return view('reports',[
            'yearReports' => $yearReports,
            'reports' => $reports
        ]);
    }

    public function getFSICReport(Request $request){
        if($request->year != null)
        {
            $issuedMonth = [
                'Guadalupe' => Helper::getIssuedFSIC('GUADALUPE',$request->year,$request->month),
                'Labangon' => Helper::getIssuedFSIC('LABANGON',$request->year,$request->month),
                'Lahug' => Helper::getIssuedFSIC('LAHUG',$request->year,$request->month),
                'Mabolo' => Helper::getIssuedFSIC('MABOLO',$request->year,$request->month),
                'Pahina Central' => Helper::getIssuedFSIC('PAHINA CENTRAL',$request->year,$request->month),
                'Pardo' => Helper::getIssuedFSIC('PARDO',$request->year,$request->month),
                'Pari-an' => Helper::getIssuedFSIC('PARI-AN',$request->year,$request->month),
                'San Nicolas' => Helper::getIssuedFSIC('SAN NICOLAS',$request->year,$request->month),
                'Talamban' => Helper::getIssuedFSIC('TALAMBAN',$request->year,$request->month),
                'CBP' => Helper::getIssuedFSIC('CBP',$request->year,$request->month)
            ];
            $issuedInMonthNew = Helper::getIssuedNewByMonthNFSIC($request->year,$request->month);
            $issuedInMonthAll = Helper::getIssuedAllByMonthFSIC($request->year,$request->month);
    
            return response()->json([
                'status' => 'success',
                'data' => ['substation' => $issuedMonth,'issuedInMonthNew' => $issuedInMonthNew,'issuedInMonthAll' => $issuedInMonthAll]
            ]);
        }

        return response()->json([
            'status' => 'cannot fetch resource',
            'data' => 'no data'
        ]);
    }
}
