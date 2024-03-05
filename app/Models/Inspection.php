<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inspection extends Model
{
    use HasFactory, SoftDeletes;

    public function receipt(){
        return $this->belongsTo(Receipt::class);
    }

    public function establishment(){
        return $this->belongsTo(Establishment::class);
    }

    public function get_id(){
        return $this->id;
    }

    public function create($input){
         
         // instantiate models
         $receipt = new Receipt();
 
         $receipt->or_no = $input['orNo'];
         $receipt->nature_of_payment = $input['natureOfPayment'];
         $receipt->amount = $input['amountPaid'];
         $receipt->date_of_payment = $input['dateOfPayment'];
         $receipt->receipt_for = $input['receiptFor'];
 
         $receipt->save();
 
         $this->inspection_date = $input['inspectionDate'];
         $this->issued_on = $input['issuedDate'];
         $this->expiry_date = date("Y-m-d",strtotime("+1 year",strtotime($input['issuedDate'])));
         $this->note = isset($input['note']) ? $input['note'] : '';
         $this->registration_status = $input['registrationStatus'];
         $this->fsic_no = $input['fsicNo'];
         $this->issued_for = $input['issued_For'];
         $this->user_id = auth()->user()->id;
         $this->receipt_id = $receipt->id;
         $this->establishment_id = $input['establishmentId'];
 
         $this->save();
        
    }

    public function archive(){
        $this->delete();
    }

    public function print_fsic(){

    }

    public static function get_inspections_by_substation_count($date){
       $substations_count =  Inspection::join('establishments', 'establishments.id','=','inspections.establishment_id')
        ->select('substation')
        ->selectRaw('count(substation) as count')
        ->whereNot('registration_status','NEW')
        ->where('status','Printed')
        ->whereBetween('issued_on',[date('Y-m-d',strtotime($date['from'])),date('Y-m-d',strtotime($date['to']))])
        ->groupBy('establishments.substation')
        ->get();

        return $substations_count;
    }
}
