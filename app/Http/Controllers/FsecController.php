<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Establishment;
use App\Models\Evaluation;
use Illuminate\Support\Facades\DB;

class FsecController extends Controller
{
    public function index(Request $request){

        $establishment = Establishment::find($request->id);
        $evaluations = Evaluation::where('establishment_id', $request->id)->get();

        return view('establishments.fsec.index', [
            'establishment' => $establishment, 
            'page_title' => 'Fire Safety Evaluation Certificate', // use to set page title inside the panel
            'evaluations' => $evaluations
        ]);
    }

    public function store(Request $request){
        $evaluation = new Evaluation();

        $evaluation->establishment_id = $request->id;
        $evaluation->or_no = $request->orNo;
        $evaluation->amount_paid = $request->amountPaid;
        $evaluation->certification_no = $request->certification;
        $evaluation->printed_by = "Admin";
        $evaluation->date_of_payment = $request->date_of_payment;
        $evaluation->date_release = $request->date_release;
        $evaluation->evaluator = $request->evaluator;
        $evaluation->boq = $request->boq;
        $evaluation->remarks = $request->remarks;
        $evaluation->purpose = $request->purpose;

        $evaluation->save();

        return redirect('/establishments/fsec/print/'.$evaluation->id);
    }

    public function print_fsec(Request $request){

        $evaluation = Evaluation::find($request->id);
        error_log($evaluation);
        return view('establishments.fsec.print_fsec',[
            'evaluation'=> $evaluation
        ]);
    }
}
