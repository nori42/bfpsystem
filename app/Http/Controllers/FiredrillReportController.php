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

        return view('reports.firedrillReports',[
            'yearReports' => $yearReports,
            'reports' => $reports
        ]);
    }

    public function getFiredrillReport(){
        
    }
}
