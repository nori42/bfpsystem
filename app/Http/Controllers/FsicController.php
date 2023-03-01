<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Inspection;
use App\Models\Payment;
use App\Models\Establishment;


class FsicController extends Controller
{
    //Inspection
    public function index()
    { 
        $establishment = DB::table('establishments')
        ->join('owners', 'establishments.owner_id', '=', 'owners.id')
        ->where('establishments.id', (int)request('id'))
        ->where('establishments.id', (int)request('id'))
        ->first();

        $inspections = DB::table('inspections')->get();


        return view('establishments.fsic.index',[
            'establishment' => $establishment,
            'inspections' => $inspections,
            'page_title' => 'Fire Safety Inspection Certificate' // use to set page title inside the panel
        ]);
    }

    //Inspection
    public function store(Request $request){
        // instantiate model
        $inspection = new Inspection();

        //get Data
        $inspection->establishment_id = $request->establishmentId;
        $inspection->inspection_date = $request->inspectionDate;
        $inspection->status = $request->status;
        $inspection->compliant_status = $request->compliantStatus;
        $inspection->action_taken = $request->actionTaken ;
        $inspection->building_type = $request->buildingType;


        //save data to database
        $inspection->save();

        return redirect('/establishments/fsic/'.$request->establishmentId)->with(['newPost'=> true,'mssg'=>'New Record Added']);
    }

    //Payment
    public function show_payment()
    {
        $establishment = DB::table('establishments')
        ->join('owners', 'establishments.owner_id', '=', 'owners.id')
        ->where('establishments.id', (int)request('id'))
        ->where('establishments.id', (int)request('id'))
        ->first();

        $payments = DB::table('payments')->get();

        return view('establishments.fsic.show_payment',[
            'establishment' => $establishment,
            'payments' => $payments,
            'page_title' => 'Fire Safety Inspection Certificate' // use to set page title inside the panel
        ]);
    }

    //Inspection
    public function store_payment(Request $request){
        // instantiate model
        $payment= new Payment();

        //get Data
        $payment->establishment_id = $request->establishmentId;
        $payment->or_no = $request->orNo;
        $payment->nature_of_Payment = $request->natureOfPayment;
        $payment->amount_paid = $request->amountPaid;
        $payment->date_issued = $request->dateIssued;
        $payment->certification = $request->certification ;
        $payment->status  = $request->status;
        $payment->printed_by = 'admin';

       

        //save data to database
        $payment->save();

        return redirect('/establishments/fsic/payment/'.$request->establishmentId)->with(['newPost'=> true,'mssg'=>'New Record Added']);
    }

    public function show_attachment()
    {
        $establishment = DB::table('establishments')
        ->join('owners', 'establishments.owner_id', '=', 'owners.id')
        ->where('establishments.id', (int)request('id'))
        ->where('establishments.id', (int)request('id'))
        ->first();

        return view('establishments.fsic.show_attachment',[
            'establishment' => $establishment,
            'page_title' => 'Fire Safety Inspection Certificate' // use to set page title inside the panel
        ]);
    }
}
