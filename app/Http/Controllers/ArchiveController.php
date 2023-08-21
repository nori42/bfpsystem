<?php

namespace App\Http\Controllers;

use App\Models\BuildingPlan;
use App\Models\Establishment;
use App\Models\User;
use Illuminate\Http\Request;

class ArchiveController extends Controller
{
    //
    public function establishments(){
        $deletedEstablishments = Establishment::onlyTrashed()->paginate(15);
        
        return view('archive.establishments',[
            'establishments' => $deletedEstablishments
        ]);
    }

    public function fsec(){
        $deletedBuildingPlan = BuildingPlan::onlyTrashed()->paginate(15);
        
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
}