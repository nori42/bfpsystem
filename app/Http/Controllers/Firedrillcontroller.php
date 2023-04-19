<?php

namespace App\Http\Controllers;

use App\Models\Establishment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FiredrillController extends Controller
{
    public function index(Request $request)
    {   
        $establishment = Establishment::find($request->id);
        $owner = $establishment->owner;
   
        return view('establishments.firedrill.index',[
            'establishment' => $establishment,
            'owner' => $owner,
            'page_title' => 'Fire Drill' // use to set page title inside the panel
        ]);
    }

}
