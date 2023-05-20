<?php

namespace App\Http\Controllers;

use App\Models\BuildingPlan;
use App\Models\Establishment;
use App\Models\Owner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    //
    public function searchOwner(Request $request){
        if($request->search != "")
        {
            
        // $owners = Owner::whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?'",["%{$request->searchQuerye}%"])->get();
        $owners = Owner::whereRaw("CONCAT(first_name, ' ', last_name) LIKE '{$request->search}%'")->limit(10)->get();
        // $owners = Owner::all();
        return response()->json([
            'status' => 'success',
            'data' => $owners
        ]);

        }

        return response()->json([
            'status' => 'success',
            'data' => 'no data'
        ]);
    }

    public function searchEstablishment(Request $request){
        if($request->search != "")
        {
            
        // $owners = Owner::whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?'",["%{$request->searchQuerye}%"])->get();

        // $establishment = Establishment::join('owners','owners.id','=','establishments.owner_id')
        // ->join('person','owners.person_id','=','person.id')
        // ->select('establishments.*','person.*')
        // ->whereRaw("CONCAT(establishment_name,'-',first_name,' ',SUBSTRING(middle_name, 1, 1),' ',last_name,'-',business_permit_no) LIKE '%{$request->search}%' ")->limit(10)->get();
        
        $establishment = DB::table('establishments')
        ->join('owners', 'owners.id', '=', 'establishments.owner_id')
        ->join('person', 'person.id', '=', 'owners.person_id')
        ->join('corporates','corporates.id','=','owners.corporate_id')
        ->select(
            'establishments.id',
            'establishments.establishment_name',
            'corporates.corporate_name',
            'person.first_name','person.middle_name',
            'person.last_name',
            'establishments.business_permit_no')
        ->whereRaw("CONCAT(establishment_name,'-',person.first_name,' ',person.last_name) LIKE '%{$request->search}%' ")->limit(10)->get();
        
        if(count($establishment) == 0){
            $establishment = DB::table('establishments')
            ->join('owners', 'owners.id', '=', 'establishments.owner_id')
            ->join('person', 'person.id', '=', 'owners.person_id')
            ->join('corporates','corporates.id','=','owners.corporate_id')
            ->select(
                'establishments.id',
                'establishments.establishment_name',
                'corporates.corporate_name',
                'person.first_name','person.middle_name',
                'person.last_name',
                'establishments.business_permit_no')
            ->whereRaw("CONCAT(establishment_name,'-',person.first_name,' ',person.last_name,'-',business_permit_no) LIKE '%$request->search%'")
            ->limit(10)->get();
        }
        
        if(count($establishment) == 0) {
            $establishment = DB::table('establishments')
        ->join('owners', 'owners.id', '=', 'establishments.owner_id')
        ->join('person', 'person.id', '=', 'owners.person_id')
        ->join('corporates','corporates.id','=','owners.corporate_id')
        ->select(
            'establishments.id',
            'establishments.establishment_name',
            'corporates.corporate_name',
            'person.first_name','person.middle_name',
            'person.last_name',
            'establishments.business_permit_no')
        ->whereRaw("CONCAT(establishment_name,'-',corporate_name) LIKE '%{$request->search}%' ")->limit(10)->get();
        }

        if(count($establishment) == 0) {
            $establishment = DB::table('establishments')
        ->join('owners', 'owners.id', '=', 'establishments.owner_id')
        ->join('person', 'person.id', '=', 'owners.person_id')
        ->join('corporates','corporates.id','=','owners.corporate_id')
        ->select(
            'establishments.id',
            'establishments.establishment_name',
            'corporates.corporate_name',
            'person.first_name','person.middle_name',
            'person.last_name',
            'establishments.business_permit_no')
        ->whereRaw("CONCAT(establishment_name,'-',corporate_name,'-',business_permit_no) LIKE '%{$request->search}%' ")->limit(10)->get();
        }

        
        return response()->json([
            'status' => 'success',
            'data' => $establishment
        ]);

        }

        return response()->json([
            'status' => 'success',
            'data' => 'no data'
        ]);
    }

    public function searchBuildingPlan(Request $request){
        if($request->search != "")
        {
            $buildingPlans = DB::table('building_plans')
            ->join('owners', 'owners.id', '=', 'building_plans.owner_id')
            ->join('person', 'person.id', '=', 'owners.person_id')
            ->join('corporates', 'corporates.id', '=', 'owners.corporate_id')
            ->select(DB::raw("CONCAT(person.first_name, ' ', person.last_name) AS name"), 'corporates.corporate_name','building_plans.status','building_plans.id')
            ->whereRaw("CONCAT(person.first_name,' ',person.last_name) LIKE '%$request->search%'")
            ->limit(10)->get();

            if(count($buildingPlans) == 0){
                $buildingPlans = DB::table('building_plans')
                ->join('owners', 'owners.id', '=', 'building_plans.owner_id')
                ->join('person', 'person.id', '=', 'owners.person_id')
                ->join('corporates', 'corporates.id', '=', 'owners.corporate_id')
                ->select(DB::raw("CONCAT(person.first_name, ' ', person.last_name) AS name"), 'corporates.corporate_name', 'building_plans.status','building_plans.id')
                ->whereRaw("corporates.corporate_name LIKE '%$request->search%'")
                ->limit(10)->get();
            }

            return response()->json([
                'status' => 'success',
                'data' => $buildingPlans
            ]);
        }

        return response()->json([
            'status' => 'success',
            'data' => 'no data'
        ]);
    }
}
