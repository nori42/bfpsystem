<?php

namespace App\Http\Controllers;

use App\Models\Establishment;
use Illuminate\Http\Request;

class ArchivedEstablishments extends Controller
{
    //
    public function __invoke()
    {
        $deletedEstablishments = Establishment::onlyTrashed()->get();
        $debug = Establishment::paginate(15);
        $debug2 = Establishment::find(1);
        
        return view('archive.establishments',[
            'page_title' => "Archived",
            'establishments' => $deletedEstablishments,
            'debug' => $debug,
            'debug2' => $debug2
        ]);
    }
}
