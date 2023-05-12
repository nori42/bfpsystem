<?php

namespace App\Http\Controllers;

use App\Models\Establishment;
use App\Models\Owner;
use Illuminate\Http\Request;

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

        $establishment = Establishment::join('person','establishments.owner_id','=','person.id')
        ->select('establishments.*','person.*')
        ->whereRaw("CONCAT(business_permit_no, '-', establishment_name,'-',first_name,' ',SUBSTRING(middle_name, 1, 1),' ',last_name) LIKE '%{$request->search}%' ")->limit(10)->get();
        // $owners = Owner::all();
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
}
