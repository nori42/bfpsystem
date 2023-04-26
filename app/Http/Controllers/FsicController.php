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
use DateTime;

class FsicController extends Controller
{
    //Inspection
    public function index(Request $request)
    {

        $establishment = Establishment::where('id', $request->id)->first();
        $inspections = Inspection::where('establishment_id', $request->id)->get();
        $owner = Owner::find($request->id);

        return view('establishments.fsic.index',[
            'establishment' => $establishment,
            'inspections' => $inspections,
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

        $establishment = $inspection->establishment;

        $inspectionDetail = Inspection::where('establishment_id', $request->id)->get();

        //load json files
        $natureOfPayment = json_decode(file_get_contents(public_path() . "/json/selectOptions/natureOfPayment.json"), true);
        $regStatus = json_decode(file_get_contents(public_path() . "/json/selectOptions/registrationStatus.json"), true);
        $issuedFor = json_decode(file_get_contents(public_path() . "/json/selectOptions/issuedFor.json"), true);
        $selectOptions = [
            "natureOfPayment"=>$natureOfPayment,
            "registrationStatus"=>$regStatus,
            "issuedFor"=>$issuedFor
        ];

        switch($request->input('action'))
        {
            case 'add':
                return view('establishments.fsic.index',[
                'newPost'=> true,
                'mssg'=>'New Record Added',
                'establishment' => $establishment,
                'inspections' => $inspectionDetail,
                'selectOptions' => $selectOptions,
                'owner' => $inspection->establishment->owner,
                'page_title' => 'Fire Safety Inspection Certificate' // use to set page title inside the panel
                ]);
            case 'addandprint':
                return redirect('/establishments/fsic/print/'.$inspection->id);
        }

    }

    public function update(Request $request){
        $inspection = Inspection::find($request->inspectionId);
        $receipt = Receipt::find($request->receiptId);

        $receipt->or_no = $request->orNoDetail;
        $receipt->nature_of_payment = $request->natureOfPaymentDetail;
        $receipt->amount = $request->amountPaidDetail;
        $receipt->date_of_payment = $request->dateOfPaymentDetail;

        $receipt->save();

        $inspection->inspection_date = $request->inspectionDateDetail;
        $inspection->building_conditions = $request->buildingConditionsDetail;
        $inspection->building_structures = $request->buildingStructuresDetail;
        $inspection->registration_status = $request->registrationStatusDetail;
        $inspection->fsic_no = $request->fsicNoDetail;
        $inspection->issued_for = $request->issuedForDetail;

        $inspection->save();

        $inspectionDetail = Inspection::where('establishment_id', $request->id)->get();

        switch($request->input('action'))
        {
            case 'save':
                return view('establishments.fsic.index',[
                    'establishment' => $inspection->establishment,
                    'inspections' =>  $inspectionDetail,
                    'owner' => $inspection->establishment->owner,
                    'page_title' => 'Fire Safety Inspection Certificate' // use to set page title inside the panel
                ]);
            case 'saveandprint':
                return redirect('/establishments/fsic/print/'.$inspection->id);
        }
        
    }

    public function print_fsic(Request $request){
        $inspection = Inspection::find($request->id);

        $inspection->expiry_date = date("m/d/Y",strtotime("+1 year"));
        $inspection->status ='Printed';
        $inspection->save();

        return redirect('/establishments/fsic/'.$inspection->establishment->id);        
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
    public function show_print_fsic(Request $request){
        // $details = DB::table('establishments')
        // ->join('owners', 'establishments.owner_id', '=', 'owners.id')
        // ->join('payments', 'payments.establishment_id', '=', 'establishments.id')
        // ->where('payments.or_no', $orNo)
        // ->first();
        $inspection = Inspection::find($request->id);
        $establishment = $inspection->establishment;
        $personName = $establishment->owner->person->first_name.' '.$establishment->owner->person->last_name;
        $corporateName = $establishment->owner->corporate->corporate_name;
        $details = [
            'personName' => $personName,
            'corporateName' => $corporateName, 
            'dateToday' => date("F d, Y",time()),
            'inspection' => $inspection,
            'expiryDate' => date("F d, Y",strtotime("+1 year")),
            'dateOfPayment' => date("m/d/Y",strtotime($inspection->receipt->date_of_payment))
        ];

        if($inspection->expiry_date != null)
        {
            return redirect('404');
        }

        
        return view('establishments/fsic/print_fsic', [
            'details' => $details,
            'inspection' => $inspection,
            'establishment' => $establishment
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
                 'fsicNo'=>$inspection->fsic_no,
                 'dateOfPayment'=>$inspection->receipt->date_of_payment,
                 'registrationStatus'=>$inspection->registration_status,
                 'issuedFor'=>$inspection->issued_for,];
        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }
}
