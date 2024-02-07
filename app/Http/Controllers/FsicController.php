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
        $inspections = Inspection::where('establishment_id', $request->id)->whereNotNull('issued_on')->orderBy('inspection_date','desc')->get();
        $notIssued = Inspection::where('issued_on',null)->first();

        if($notIssued)
        $notIssued->forceDelete();

        $owner = $establishment->owner;

        return view('establishments.fsic.index',[
            'establishment' => $establishment,
            'inspections' => $inspections,
            'owner' => $owner,
            'representative' => $establishment->getOwnerName()
        ]);
    }

    //Inspection
    public function store(Request $request){

        if(Inspection::where('fsic_no',$request->fsicNo)->exists())
            return back()->with('toastMssg','FSIC No. already in used');
        
        // instantiate model
        $inspection = new Inspection();
        $receipt = new Receipt();

        $receipt->or_no = $request->orNo;
        $receipt->nature_of_payment = $request->natureOfPayment;
        $receipt->amount = $request->amountPaid;
        $receipt->date_of_payment = $request->dateOfPayment;
        $receipt->receipt_for = $request->receiptFor;

        $receipt->save();

        $inspection->inspection_date = $request->inspectionDate;
        // $inspection->building_conditions = $request->buildingConditions;
        $inspection->note = $request->note;
        // $inspection->building_structures = $request->buildingStructures;
        $inspection->registration_status = $request->registrationStatus;
        $inspection->fsic_no = $request->fsicNo;
        $inspection->issued_for = $request->issued_For;
        $inspection->user_id = auth()->user()->id;
        $inspection->receipt_id = $receipt->id;
        $inspection->establishment_id = $request->establishmentId;

        $inspection->save();

        $establishment = $inspection->establishment;

        $inspectionDetail = Inspection::where('establishment_id', $request->id)->orderBy('inspection_date','desc')->get();

        //load json files
        $natureOfPayment = json_decode(file_get_contents(public_path() . "/json/selectOptions/natureOfPayment.json"), true);
        $regStatus = json_decode(file_get_contents(public_path() . "/json/selectOptions/registrationStatus.json"), true);
        $issuedFor = json_decode(file_get_contents(public_path() . "/json/selectOptions/issuedFor.json"), true);
        $selectOptions = [
            "natureOfPayment"=>$natureOfPayment,
            "registrationStatus"=>$regStatus,
            "issuedFor"=>$issuedFor
        ];

        // ActivityLogger::fsicLog($establishment->establishment_name,Activity::AddInspection); 

        switch($request->input('action'))
        {
            case 'add':
                return view('establishments.fsic.index',[
                'newPost'=> true,
                'toastMssg'=>'Inspection Added Successfully',
                'isAdd' => true,
                'establishment' => $establishment,
                'inspections' => $inspectionDetail,
                'selectOptions' => $selectOptions,
                'owner' => $inspection->establishment->owner,
                'representative' => $establishment->getOwnerName(),
                'page_title' => 'Fire Safety Inspection Certificate' // use to set page title inside the panel
                ]);
            case 'addandprint':
                return redirect('/fsic/print/'.$inspection->id);
            case 'addandprintoccupancy':
                return redirect('/occupancy/print/'.$inspection->id);
        }
    }

    public function update(Request $request){
        
        $inspection = Inspection::find($request->inspectionId);
        $receipt = Receipt::find($request->receiptId);

        if($request->input('action') == "delete"){
            $establishment = $inspection->establishment;

            $logMessage = "Deleted the inspection: FSIC.NO {$inspection->fsic_no}";            
            ActivityLogger::logActivity($logMessage,'ESTABLISHMENT');

            //Update fsic number to null 
            $inspection->fsic_no = null;
            $inspection->save();    
            $inspection->delete();

            $inspectionList = Inspection::where('establishment_id', $request->id)->orderBy('inspection_date','desc')->get();



            return view('establishments.fsic.index',[
                'establishment' => $inspection->establishment,
                'inspections' =>  $inspectionList,
                'owner' => $establishment->owner,
                'representative' => $establishment->getOwnerName(),
                'toastMssg' => "Inspection has been moved to archive",
            ]);
        }

        $receipt->or_no = $request->orNoDetail;
        $receipt->nature_of_payment = $request->natureOfPaymentDetail;
        $receipt->amount = $request->amountPaidDetail;
        $receipt->date_of_payment = $request->dateOfPaymentDetail;

        $receipt->save();

        $inspection->inspection_date = $request->inspectionDateDetail;
        // $inspection->building_conditions = $request->buildingConditionsDetail;
        // $inspection->building_structures = $request->buildingStructuresDetail;
        $inspection->note = $request->noteDetail;
        $inspection->registration_status = $request->registrationStatusDetail;
        $inspection->fsic_no = $request->fsicNoDetail;
        // $inspection->issued_for = $request->issuedForDetail;

        $inspection->save();

        $inspectionList = Inspection::where('establishment_id', $request->id)->orderBy('inspection_date','desc')->get();

        switch($request->input('action'))
        {
            case 'save':
                return view('establishments.fsic.index',[
                    'establishment' => $inspection->establishment,
                    'inspections' =>  $inspectionList,
                    'owner' => $inspection->establishment->owner,
                    'representative' => $inspection->establishment->getOwnerName(),
                    'inpsectUpdatedId' => $inspection->id,
                    'toastMssg' => "Updated Successfully",
                    'isUpdate' => true,
                    'page_title' => 'Fire Safety Inspection Certificate' // use to set page title inside the panel
                ]);
            case 'saveandprint':
                return redirect('/fsic/print/'.$inspection->id);

        }
        
    }


    //Attachment
    public function show_attachment(Request $request)
    {
        $establishment = Establishment::where('id', $request->id)->first();
        $establishment_id = $request->id;
        $owner = $establishment->owner;
        $attachFor = 'fsic';
        $files = File::whereHas('attachments', function ($query) use ($establishment_id,$attachFor) {
            $query->where('establishment_id', $establishment_id)->where('attach_for', $attachFor);
        })->get();

        return view('establishments.fsic.attachment_fsic',[
            'establishment' => $establishment,
            'owner' => $owner,
            'representative' => $establishment->getOwnerName(),
            'files' =>  $files,
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
