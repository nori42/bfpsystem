<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Establishment;
use Illuminate\Support\Facades\DB;

class FsecController extends Controller
{
    public function index(){

        $establishment = DB::table('establishments')
        ->join('owners', 'establishments.owner_id', '=', 'owners.id')
        ->where('establishments.id', (int)request('id'))
        ->where('establishments.id', (int)request('id'))
        ->first();


        return view('establishments.fsec.index', [
            'establishment' => $establishment, 
            'page_title' => 'Fire Safety Evaluation Certificate', // use to set page title inside the panel

        ]);
    }
}
