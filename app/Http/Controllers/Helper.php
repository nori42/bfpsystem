<?php

namespace App\Http\Controllers;

use App\Models\Inspection;
use App\Models\Owner;

class Helper {
    
    public static function getIssuedThisMonthFSIC($substation){
         return Inspection::join('establishments', 'establishments.id', '=', 'inspections.establishment_id')
        ->where('inspections.status', 'Printed')
        ->whereNot('registration_status','NEW')
        ->where('establishments.substation', $substation)
        ->whereYear('inspections.issued_on', '=', now()->year)
        ->whereMonth('inspections.issued_on', '=', now()->month)
        ->count();
    }
    
        
    public static function getIssuedFSIC($substation, $year, $month){
        return Inspection::join('establishments', 'establishments.id', '=', 'inspections.establishment_id')
        ->where('inspections.status', 'Printed')
        ->whereNot('registration_status','NEW')
        ->where('establishments.substation', $substation)
        ->whereYear('inspections.issued_on', '=', $year)
        ->whereMonth('inspections.issued_on', '=', $month)
        ->count();
    }

    public static function getIssuedAllByMonthFSIC($year,$month){
        return Inspection::select()
        ->where('inspections.status', 'Printed')
        ->whereYear('inspections.issued_on', '=', $year)
        ->whereMonth('inspections.issued_on', '=', $month)
        ->count();
    }

    public static function getIssuedNewByMonthNFSIC($year,$month){
        return Inspection::select()
        ->where('status', 'Printed')
        ->where('registration_status','NEW')
        ->whereYear('issued_on', '=', $year)
        ->whereMonth('issued_on', '=', $month)
        ->count();
    }

    public static function getRepresentativeName($ownerId){
        $owner = Owner::find($ownerId);
        $person = $owner->person;
        $representative = null;

        if ($person->last_name != null) {

            if($person->middle_name != null)
            $personName = $person->first_name . ' ' . $person->middle_name . ' ' . $person->last_name . ' ' . $person->suffix;
            else {
                $personName = $person->first_name . ' ' . $person->last_name . ' ' . $person->suffix;
            }
        }
        
        if ($owner->corporate != null) {
            $company = $owner->corporate;
        }
        
        // if($company->corporate_name != null  && $person->last_name != null)
        // {
        //     $representative = $personName.'/'.$company->corporate_name;
        // }
        // else 
        if($person->last_name != null){
            $representative = $personName;
        }
        else {
            $representative = $company->corporate_name;
        }

        return $representative;
    }

    public static function randPass($length){
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $randomString = '';
         
            for ($i = 0; $i < $length; $i++) {
                $index = rand(0, strlen($characters) - 1);
                $randomString .= $characters[$index];
            }
         
            return $randomString;
    }

}