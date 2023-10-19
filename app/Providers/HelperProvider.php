<?php

namespace App\Providers;

use App\Models\Establishment;
use App\Models\Inspection;

class HelperProvider {

    public static function getNotifications()
    {
            $inspectionsCount = Inspection::where('expiry_date',date('Y-m-d'))->count();
            $firedrillQuarterCount = Establishment::where('firedrill_is_expired',true)
                ->where('firedrill_type','QUARTERLY')
                ->count();
                
            $firedrillSemesterCount = Establishment::where('firedrill_is_expired',true)
                ->where('firedrill_type','SEMESTER')
                ->count();
            
            $expiredInspections = Inspection::join('establishments','establishments.id','=','inspections.establishment_id')
            ->where('establishments.inspection_is_expired',1)
            ->whereBetween('expiry_date',[date('Y-m-d',strtotime('-2 days', time())),date('Y-m-d')])
            ->orderBy('expiry_date','desc')
            ->get();

            $expired = $expiredInspections->groupBy('expiry_date');

            $expiredCount = [
                'expiredInspections' => $expired->all(),
                'inspectionCount' => $inspectionsCount,
                'firedrillQuarterCount' => $firedrillQuarterCount,
                'firedrillSemesterCount' => $firedrillSemesterCount];

            return $expiredCount;
    }
}