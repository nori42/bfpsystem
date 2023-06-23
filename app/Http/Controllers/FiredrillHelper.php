<?php

namespace App\Http\Controllers;

use App\Models\Firedrill;
use App\Models\Inspection;
use App\Models\Owner;

class FiredrillHelper {
    
   public static function getIssuedFiredrillCount($substation, $year, $month){
       return Firedrill::join('establishments', 'establishments.id', '=', 'firedrills.establishment_id')
       ->where('establishments.substation', $substation)
       ->whereYear('firedrills.issued_on', '=', $year)
       ->whereMonth('firedrills.issued_on', '=', $month)
       ->count();
   }
   
}