<?php

namespace App\Http\Controllers;

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
}
