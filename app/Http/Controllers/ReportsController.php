<?php

namespace App\Http\Controllers;

use App\Models\Firedrill;
use App\Models\Inspection;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    //
    public function show_fsic(Request $request){
        $inspections = Inspection::whereYear('issued_on','=', $request->year)
        ->whereMonth('issued_on','=',$request->month)
        ->orderBy('issued_on')
        ->get();

        return view('reports.print.fsic',[
            'inspections' => $inspections,
            'date' =>['year' => $request->year,'month'=> date('F',strtotime('1975-'.$request->month.'-01'))]
        ]);
    }
    public function show_firedrill(Request $request){

        if($request->claimed == "true" && $request->claimed != null){
            $firedrills = Firedrill::whereYear('issued_on','=',$request->year)
            ->whereMonth('issued_on','=',$request->month)
            ->whereNull('date_claimed')
            ->get();
        }
        else{
            $firedrills = Firedrill::whereYear('issued_on','=',$request->year)
            ->whereMonth('issued_on','=',$request->month)
            ->whereNotNull('date_claimed')
            ->get();
        }

        return view('reports.print.firedrill',[
            'firedrills' => $firedrills,
            'date' =>['year' => $request->year,'month'=> date('F',strtotime('1975-'.$request->month.'-01'))]
        ]);
    }

    public function show_fsec(Request $request){
        return view('reports.print.fsec');
    }

}