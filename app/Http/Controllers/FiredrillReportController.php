<?php

namespace App\Http\Controllers;

use App\Models\Firedrill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FiredrillReportController extends Controller
{
    //
    public function index(Request $request){
        $yearReports = DB::table('firedrills')
        ->select(DB::raw('DISTINCT YEAR(issued_on) AS year'))
        ->whereNotNull('issued_on')
        ->orderBy('year', 'desc')
        ->get();

        
        $reports = [];

        
        foreach($yearReports as $item){
            $yearlyReports = DB::table('firedrills')
            ->select(DB::raw('DISTINCT MONTH(issued_on) AS month'), DB::raw('COUNT(issued_on) AS count'))
            ->whereYear('issued_on', '=', $item->year)
            ->groupBy(DB::raw('MONTH(issued_on)'))
            ->get();

            $reports[$item->year] = $yearlyReports->toArray();
        }

        if(count($yearReports) != 0){
            $selectedYear = $request->selectedYear ? $request->selectedYear :$yearReports->first()->year;

            $monthReports = DB::table('firedrills')
            ->select(DB::raw('DISTINCT MONTH(issued_on) as month'))
            ->whereNotNull('issued_on')
            ->whereYear('issued_on', '=',$selectedYear)
            ->orderBy('month', 'asc')
            ->get();

            $selectedMonth = $request->selectedMonth ? $request->selectedMonth : $monthReports->first()->month;

            $firedrillIssuedSubstation = [
                'Guadalupe' => FiredrillHelper::getIssuedFiredrillCount('GUADALUPE',$selectedYear,$selectedMonth),
                'Labangon' => FiredrillHelper::getIssuedFiredrillCount('LABANGON',$selectedYear,$selectedMonth),
                'Lahug' => FiredrillHelper::getIssuedFiredrillCount('LAHUG',$selectedYear,$selectedMonth),
                'Mabolo' => FiredrillHelper::getIssuedFiredrillCount('MABOLO',$selectedYear,$selectedMonth),
                'Pahina Central' => FiredrillHelper::getIssuedFiredrillCount('PAHINA CENTRAL',$selectedYear,$selectedMonth),
                'Pardo' => FiredrillHelper::getIssuedFiredrillCount('PARDO',$selectedYear,$selectedMonth),
                'Pari-an' => FiredrillHelper::getIssuedFiredrillCount('PARI-AN',$selectedYear,$selectedMonth),
                'San Nicolas' => FiredrillHelper::getIssuedFiredrillCount('SAN NICOLAS',$selectedYear,$selectedMonth),
                'Talamban' => FiredrillHelper::getIssuedFiredrillCount('TALAMBAN',$selectedYear,$selectedMonth)
            ];

            $substationTotalCountFiredrill = 0;
            $cbpFiredrill = FiredrillHelper::getIssuedFiredrillCount('CBP',$selectedYear,$selectedMonth);
            $unclaimed = Firedrill::whereNull('date_claimed')->get();

            foreach($firedrillIssuedSubstation as $key => $value){
                $substationTotalCountFiredrill += $value;
            }
            
            $firedrillIssued = [
                'issuedBySubstation' => $firedrillIssuedSubstation,
                'CBP' => $cbpFiredrill,
                'totalSubstation' => $substationTotalCountFiredrill,
                'totalGrand' => $cbpFiredrill + $substationTotalCountFiredrill,
                'unclaimed' => count($unclaimed)
            ];
        }

        $unclaimed = $request->unclaimed ? true : false;

        return view('reports.firedrillReports',[
            'yearReports' => $yearReports,
            'monthReports' => $monthReports,
            'firedrillIssued' =>$firedrillIssued,
            'reports' => $reports,
            'selectedReports' => ['month' =>$selectedMonth, 'year' => $selectedYear,'unclaimed'=>$unclaimed]
        ]);
    }
}
