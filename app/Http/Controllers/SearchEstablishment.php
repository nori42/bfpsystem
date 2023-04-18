<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SearchEstablishment extends Controller
{
    //
    public function index(Request $request)
    {
        return view('search.index',[
            'page_title' => 'Search'
        ]);
    }

}
