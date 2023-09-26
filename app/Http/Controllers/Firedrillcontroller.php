<?php

namespace App\Http\Controllers;

use App\Models\Establishment;
use App\Models\File;
use App\Models\Firedrill;
use App\Models\Owner;
use App\Models\Receipt;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FiredrillController extends Controller
{
    public function index(Request $request)
    {   
        $establishment = Establishment::find($request->id);
        $owner = $establishment->owner;
        $firedrills= Firedrill::where('establishment_id', $request->id)->orderBy('id','desc')->get();
   
        return view('establishments.firedrill.index',[
            'firedrills' => $firedrills,
            'establishment' => $establishment,
            'owner' => $owner,
            'representative' => Helper::getRepresentativeName($establishment->owner_id),
            'page_title' => 'Fire Drill' // use to set page title inside the panel
        ]);
    }

    public function store(Request $request){

        $receipt = new Receipt();
        $firedrill = new Firedrill();
        $establishment = Establishment::find($request->estabId);
        $owner = $establishment->owner;

        $receipt->or_no = $request->orNo;
        // $receipt->payor = $request->payor;
        $receipt->amount = $request->amountPaid;
        $receipt->nature_of_payment = $request->natureOfPayment;
        $receipt->receipt_for = $request->receiptFor;
        $receipt->date_of_payment = $request->dateOfPayment;
        
        $receipt->save();
        $firedrill->validity_term = $request->validityTerm;
        $firedrill->term_type = $request->validity;
        $firedrill->date_made = $request->dateMade;
        $firedrill->user_id = auth()->user()->id;
        $firedrill->receipt_id = $receipt->id;
        $firedrill->establishment_id = $request->estabId;
        $firedrill->year =$request->year;
        
        $establishment->firedrill_type = $request->validity;
        $establishment->save();
        $firedrill->save();

        // ActivityLogger::firedrillLog($establishment->establishment_name,Activity::AddFiredrill);
        
        $firedrills = Firedrill::where('establishment_id', $request->estabId)->orderBy('id','desc')->get();

        if($request->action == "add")
        {
            return view('establishments.firedrill.index',[
                'firedrills' => $firedrills,
                'establishment' => $establishment,
                'isAdd'=>true,
                'toastMssg' => 'Firedrill Added',
                'owner' => $owner,
                'representative' => Helper::getRepresentativeName($establishment->owner_id)
            ]);
        }
        else
        {
            return redirect('/firedrill/print/'.$firedrill->id)->with('nameExtension',$request->nameExtension);
        }
        
    }

    public function update(Request $request){

        $firedrill = Firedrill::find($request->firedrillId);
        $receipt = $firedrill->receipt;
        $establishment = Establishment::find($request->estabId);
        $owner = $establishment->owner;
        
        if($request->action =='save' || $request->action == 'saveandprint')
        {

            $receipt->or_no = $request->orNo;
            $receipt->amount = $request->amountPaid;
            $receipt->date_of_payment = $request->dateOfPayment;
            $receipt->save();
    
            $firedrill->control_no = $request->controlNo;
            $firedrill->validity_term = $request->validityTerm;
            $firedrill->date_made = $request->dateMade;
        }


        if($request->action == "claimcertificate")
        {
            $firedrill->date_claimed = Carbon::now();
            
            if($request->claimedBy == null)
            {
                $personName = $owner->person->first_name.' '.$owner->person->middle_name[0].' '.$owner->person->last_name;
                $firedrill->claimed_by = $personName;
            }
            else
            {
                $firedrill->claimed_by = strtoupper($request->claimedBy);
            }
        }
        
        $firedrill->save();

        $firedrills = Firedrill::where('establishment_id', $request->estabId)->orderBy('id','desc')->get();

        if($request->action == "save" || $request->action == "claimcertificate")
        {
            return view('establishments.firedrill.index',[
                'firedrills' => $firedrills,
                'establishment' => $establishment,
                'owner' => $owner,
                'representative' => Helper::getRepresentativeName($establishment->owner_id),
                'isUpdate' =>true,
                'toastMssg' => 'Updated Successfully',
                'firedrillUpdatedId' => $firedrill->id
            ]);
        }
        else
        {
            return redirect('/firedrill/print/'.$firedrill->id)->with('nameExtension',$request->nameExtension);
        }
    }

    public function show_print_firedrill(Request $request){
        $firedrill = Firedrill::find($request->id);
        $receipt = $firedrill->receipt;
        $establishment = $firedrill->establishment;
        $owner = $establishment->owner;
        $personName =  $owner->person->first_name.' '.$owner->person->middle_name.' '.$owner->person->last_name;
        $company = $owner->corporate->corporate_name;
        
        // $representative = ($owner->person->last_name != null) ? $personName: $company;
        $representative = Helper::getRepresentativeName($establishment->owner_id);
        
        return view('establishments.firedrill.print_firedrill',[
            'estabId' => $establishment->id,
            'firedrillId' => $firedrill->id,
            'firedrill' => $firedrill,
            'controlNo' => $firedrill->control_no,
            'issuedOn' =>['day' => date('dS'),'month'=> date('F')],
            'validity' => $firedrill->validity_term.' '.$firedrill->year,
            'establishment' => $establishment->establishment_name,
            'dateMade' => $firedrill->date_made,
            'address' => $firedrill->establishment->address,
            'representative' => $representative,
            'payment' => ['orNo' => $receipt->or_no,'amountPaid'=>$receipt->amount, 'datePayment' => date('m/d/Y',strtotime($receipt->date_of_payment))]
        ]);
    }

    public function print_firedrill(Request $request){
        $firedrill = Firedrill::find($request->id);

        if($firedrill->issued_on == null) {
            $firedrill->issued_on = date('Y-m-d');
            $firedrill->save();
        }

        return redirect('/establishments'.'/'.$firedrill->establishment->id.'/firedrill');        
    }

    //Attachment
    public function show_attachment(Request $request)
    {
        $establishment = Establishment::where('id', $request->id)->first();
        $owner = Owner::where('id', $request->id)->first();
        $establishment_id = $request->id;
        $attachFor = 'firedrill';
        $files = File::whereHas('attachments', function ($query) use ($establishment_id,$attachFor) {
            $query->where('establishment_id', $establishment_id)->where('attach_for', $attachFor);
        })->get();

        return view('establishments.firedrill.attachment_firedrill',[
            'establishment' => $establishment,
            'owner' => $owner,
            'representative' => Helper::getRepresentativeName($establishment->owner_id),
            'files' =>  $files,
        ]);
    }
}
