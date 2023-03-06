<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FsecController extends Controller
{
    //
    public function index(){
        return view('fsec.index',[
            'page_title' => 'Fire Safe Evaluation Clearance'
        ]);
    }
}
