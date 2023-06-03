<?php

namespace App\Http\Controllers;

use App\Models\Inspection;

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

}