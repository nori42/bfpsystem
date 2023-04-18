<?php

namespace App\Http\Controllers;

use App\Models\Attachments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Inspection;
use App\Models\Payment;
use App\Models\Establishment;
use App\Models\File;
use App\Models\Owner;
use App\Models\Receipt;
use Carbon\Carbon;


class FsicController extends Controller
{
    //Inspection
    public function index(Request $request)
    {

        $establishment = Establishment::where('id', $request->id)->first();
        $inspections = Inspection::where('establishment_id', $request->id)->get();
        $owner = Owner::find($request->id);

        //load json files
        $natureOfPayment = json_decode(file_get_contents(public_path() . "/json/natureOfPayment.json"), true);

        return view('establishments.fsic.index',[
            'establishment' => $establishment,
            'inspections' => $inspections,
            'natureOfPayment' => $natureOfPayment,
            'owner' => $owner,
            'page_title' => 'Fire Safety Inspection Certificate' // use to set page title inside the panel
        ]);
    }

    //Inspection
    public function store(Request $request){
        // instantiate model
        $inspection = new Inspection();
        $receipt = new Receipt();

        $receipt->or_no = $request->orNo;
        $receipt->payor = $request->payor;
        $receipt->nature_of_payment = $request->natureOfPayment;
        $receipt->amount = $request->amountPaid;
        $receipt->date_of_payment = $request->dateOfPayment;
        $receipt->receipt_for = $request->receiptFor;

        $receipt->save();

        $inspection->inspection_date = $request->inspectionDate;
        $inspection->building_conditions = $request->buildingConditions;
        $inspection->building_structures = $request->buildingStructures;
        $inspection->registration_status = $request->registrationStatus;
        $inspection->fsic_no = $request->fsicNo;
        $inspection->issued_for = $request->issuedFor;
        $inspection->receipt_id = $receipt->id;
        $inspection->establishment_id = $request->establishmentId;

        $inspection->save();

        if($request->input('action') === 'save'){
            return redirect('/establishments/fsic/'.$request->establishmentId)->with(['newPost'=> true,'mssg'=>'New Record Added']);
        } else {
            return redirect('/establishments/fsic/print/'.$request->establishmentId);
        }
    }

    //Payment
    public function show_payment(Request $request)
    {   
        // Retrieve Data
        $establishment = Establishment::where('id', $request->id)->first();
        $owner = Owner::where('id', $request->id)->first();
        $payments = Payment::where('establishment_id', $request->id)->get();

        foreach($payments as $payment)
        {
            $date = Carbon::parse($payment->created_at)->format('m/d/Y');
            $payment->created_at = $date;
        }

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
        return redirect('/establishments/fsic/print/'.$payment->id);
    }

    //Attachment
    public function show_attachment(Request $request)
    {
        $establishment = Establishment::where('id', $request->id)->first();
        $owner = Owner::where('id', $request->id)->first();
        $establishment_id = $request->id;
        $attachFor = $request->attachFor;
        $files = File::whereHas('attachments', function ($query) use ($establishment_id,$attachFor) {
            $query->where('establishment_id', $establishment_id)->where('attach_for', $attachFor);
        })->get();

        return view('establishments.fsic.attachment_fsic',[
            'establishment' => $establishment,
            'owner' => $owner,
            'files' =>  $files,
            'page_title' => 'Fire Safety Inspection Certificate' // use to set page title inside the panel
        ]);
    }


    //Print
    public function print_fsic(Request $request){
        // $details = DB::table('establishments')
        // ->join('owners', 'establishments.owner_id', '=', 'owners.id')
        // ->join('payments', 'payments.establishment_id', '=', 'establishments.id')
        // ->where('payments.or_no', $orNo)
        // ->first();
        
        $details= Receipt::find($request->id);

        // reformat issued date to full month
        // $createdFormat= Carbon::parse($payment->created_at)->format('F d Y');
        $createdDate = Carbon::parse($details->created_at)->format('F d Y');

        $expireFormat = Carbon::parse($details->expiry_date)->format('m/d/Y');
        $details->expiry_date = $expireFormat;

        $datePaymentFormat = Carbon::parse($details->date_of_payment)->format('m/d/Y');
        $details->date_of_payment = $datePaymentFormat;
        
        return view('establishments/fsic/print_fsic', [
            'details' => $details,
            'createdDate' => $createdDate
        ]);
    }

    public function getInspection(Request $request){

        $inspection= Inspection::find($request->id);

        $data = ['inspectionDate' => $inspection->inspection_date,
                 'buildingCondtions'=>$inspection->building_conditions,
                 'buildingStructures'=>$inspection->building_structures,
                 'orNo'=>$inspection->receipt->or_no,
                 'natureOfPayment'=>$inspection->receipt->nature_of_payment,
                 'amount'=>$inspection->receipt->amount,
                 'dateOfPayment'=>$inspection->receipt->date_of_payment,
                 'registrationStatus'=>$inspection->registration_status,
                 'issuedFor'=>$inspection->issued_for,];
        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }
}
