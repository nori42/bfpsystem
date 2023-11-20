<?php

namespace App\Http\Controllers;

use App\Models\BuildingPlan;
use App\Models\Establishment;
use App\Models\Firedrill;
use App\Models\Inspection;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ArchiveController extends Controller
{
    //
    public function establishments(){
        $deletedEstablishments = DB::table('establishments')->join('owners','owners.id','=','establishments.owner_id')->whereNotNull('deleted_at')->paginate(15);
        
        return view('archive.establishments',[
            'establishments' => $deletedEstablishments
        ]);
    }

    public function fsec(){
        $deletedBuildingPlan = DB::table('building_plans')->join('owners','owners.id','=','building_plans.owner_id')->whereNotNull('deleted_at')->paginate(15);
        
        return view('archive.fsec',[
            'buildingPlan' => $deletedBuildingPlan
        ]);
    }

    public function users(){
        $deletedUsers = User::onlyTrashed()->paginate(15);
        
        return view('archive.users',[
            'users' => $deletedUsers
        ]);
    }

    public function fsic(){
        // $deletedInspection = Inspection::onlyTrashed()->paginate(15);
        $deletedInspection = DB::table('establishments')
        ->join('inspections','inspections.establishment_id','=','establishments.id')
        ->whereNotNull('inspections.deleted_at'
        )->paginate(15);

        return view('archive.inspection',[
            'inspections' => $deletedInspection
        ]);
    }

    public function firedrill(){
        // $deletedFiredrill = Firedrill::onlyTrashed()->paginate(15);
        $deletedFiredrill = DB::table('establishments')
        ->join('firedrills','firedrills.establishment_id','=','establishments.id')
        ->join('receipts','receipts.id','=','firedrills.receipt_id')
        ->whereNotNull('firedrills.deleted_at'
        )->paginate(15);

        return view('archive.firedrill',[
            'firedrills' => $deletedFiredrill
        ]);
    }
}
