<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FSECReportController extends Controller
{
    public function index(){
        $yearReports = DB::table('evaluations')
        ->select(DB::raw('DISTINCT YEAR(created_at) AS year'))
        ->where('remarks','APPROVED')
        ->orderBy('year', 'desc')
        ->get();


        $reports = [];

        foreach($yearReports as $item){
            $yearlyReports = DB::table('evaluations')
            ->select(DB::raw('DISTINCT MONTH(created_at) AS month'), DB::raw('COUNT(created_at) AS count'))
            ->whereYear('created_at', '=', $item->year)
            ->where('remarks','APPROVED')
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->get();

            $reports[$item->year] = $yearlyReports->toArray();
        }

        return view('reports.fsecReports',[
            'yearReports' => $yearReports,
            'reports' => $reports
        ]);
        
    }
}
