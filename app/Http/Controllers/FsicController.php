<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Inspection;
use App\Models\Payment;
use App\Models\Establishment;
use App\Models\Owner;
use Carbon\Carbon;


class FsicController extends Controller
{
    //Inspection
    public function index(Request $request)
    {

        $establishment = Establishment::where('id', $request->id)->first();
        $owner = Owner::where('id', $request->id)->first();
        $inspections = Inspection::where('establishment_id', $request->id)->get();


        return view('establishments.fsic.index',[
            'establishment' => $establishment,
            'owner' => $owner,
            'inspections' => $inspections,
            'page_title' => 'Fire Safety Inspection Certificate' // use to set page title inside the panel
        ]);
    }

    //Inspection
    public function store(Request $request){
        // instantiate model
        $inspection = new Inspection();

        $inspectionCount = Inspection::where('establishment_id', $request->id)->get()->count() + 1;

        //get Data
        $inspection->establishment_id = $request->establishmentId;
        $inspection->record_no = $inspectionCount;
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
    public function show_payment(Request $request)
    {   
        // Retrieve Data
        $establishment = Establishment::where('id', $request->id)->first();
        $owner = Owner::where('id', $request->id)->first();
        $payments = Payment::where('establishment_id', $request->id)->get();

        //load json files
        $natureOfPayment = json_decode(file_get_contents(public_path() . "/json/natureOfPayment.json"), true);

        return view('establishments.fsic.show_payment',[
            'establishment' => $establishment,
            'owner' =>$owner,
            'payments' => $payments,
            'page_title' => 'Fire Safety Inspection Certificate', // use to set page title inside the panel
            'natureOfPayment' => $natureOfPayment
        ]);
    }

    //Payment
    public function store_payment(Request $request){
        // instantiate model
        $payment = new Payment();

        //get Data
        $payment->establishment_id = $request->establishmentId;
        $payment->record_no = Payment::where('establishment_id', $request->establishmentId)->get()->count() + 1;
        $payment->or_no = $request->orNo;
        $payment->nature_of_Payment = $request->natureOfPayment;
        $payment->amount_paid = $request->amountPaid;
        $payment->certification = $request->certification ;
        $payment->status  = $request->status;
        $payment->printed_by = 'admin';
        $payment->issued_for = $request->issuedFor;
        $payment->building_condition = $request->buildingConditions;
        $payment->building_structures = $request->buildingStructures;
        $payment->expiry_date = $request->expiry_date;
        $payment->date_of_payment = $request->date_of_payment;
        //save data to database
        
        $payment->save();

        // return redirect('/establishments/fsic/payment/'.$request->establishmentId)->with(['newPost'=> true,'mssg'=>'New Record Added']);
        return redirect('/establishments/fsic/print/' . $request->establishmentId . "&" . $request->orNo);
    }

    //Attachment
    public function show_attachment(Request $request)
    {
        $establishment = Establishment::where('id', $request->id)->first();
        $owner = Owner::where('id', $request->id)->first();

        return view('establishments.fsic.show_attachment',[
            'establishment' => $establishment,
            'establishment' => $owner,
            'page_title' => 'Fire Safety Inspection Certificate' // use to set page title inside the panel
        ]);
    }


    //Print
    public function print_fsic(Request $request){
        $id = (int)request('id');
        $orNo = (int)request('orNo');

        $details = DB::table('establishments')
        ->join('owners', 'establishments.owner_id', '=', 'owners.id')
        ->join('payments', 'payments.establishment_id', '=', 'establishments.id')
        ->where('payments.or_no', $orNo)
        ->first();

        // reformat issued date to full month
        $date = Carbon::parse($details->created_at)->format('F d Y');
        $details->created_at = $date;

        $date = Carbon::parse($details->expiry_date)->format('m/d/Y');
        $details->expiry_date = $date;

        $date = Carbon::parse($details->date_of_payment)->format('m/d/Y');
        $details->date_of_payment = $date;
        
        return view('establishments/fsic/print_fsic', [
            'id' => $id,
            'details' => $details
        ]);
    }
}
