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
        $deletedEstablishments = DB::table('establishments')
        ->whereNotNull('deleted_at')
        ->paginate(15);
        
        return view('archive.establishments',[
            'establishments' => $deletedEstablishments
        ]);
    }

    public function fsec(){
        $deletedBuildingPlan = DB::table('building_plans')
        ->whereNotNull('deleted_at')
        ->paginate(15);
        
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
        ->select('inspections.id','establishments.establishment_name','inspection_date','issued_on','fsic_no','registration_status','expiry_date','inspections.deleted_at')
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
        ->select('firedrills.id','control_no','validity_term','date_made','issued_on','date_claimed','firedrills.deleted_at','establishment_name')
        ->whereNotNull('firedrills.deleted_at'
        )->paginate(15);

        return view('archive.firedrill',[
            'firedrills' => $deletedFiredrill
        ]);
    }

    // Delete
    public function destroyUser(Request $request){
        error_log($request->deletionId);
        $user = User::onlyTrashed()->find($request->deletionId);
        $user->forceDelete();

        return redirect('archived/users');
    }

    public function destroyInspection(Request $request){
        error_log($request->deletionId);
        $inspection = Inspection::onlyTrashed()->find($request->deletionId);
        $inspection->forceDelete();

        return redirect('archived/fsic');
    }

    public function destroyEstablishment(Request $request){
        error_log($request->deletionId);
        $establishment = Establishment::onlyTrashed()->find($request->deletionId);
        $establishment->forceDelete();

        return redirect('archived/establishments');
    }

    public function destroyFiredrill(Request $request){
        error_log($request->deletionId);
        $firedrill = Firedrill::onlyTrashed()->find($request->deletionId);
        $firedrill->forceDelete();

        return redirect('archived/firedrill');
    }

    public function destroyFsec(Request $request){
        error_log($request->deletionId);
        $buildingPlan = BuildingPlan::onlyTrashed()->find($request->deletionId);
        $buildingPlan->forceDelete();

        return redirect('archived/fsec');
    }
}
