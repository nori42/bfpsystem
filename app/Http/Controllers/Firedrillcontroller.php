<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Firedrillcontroller extends Controller
{
    public function index()
    {   
        //Owners Information 
        $establishment = DB::table('establishments')
        ->join('owners', 'establishments.owner_id', '=', 'owners.id')
        ->where('establishments.id', (int)request('id'))
        ->where('establishments.id', (int)request('id'))
        ->first();
   
        return view('establishments.firedrill.index',[
            'establishment' => $establishment,
            'page_title' => 'Fire Drill' // use to set page title inside the panel
        ]);
    }

}
