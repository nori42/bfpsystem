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

        return view('archived',[
            'page_title' => "Archived",
            'establishments' => $deletedEstablishments
        ]);
    }
}
