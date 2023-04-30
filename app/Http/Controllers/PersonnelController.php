<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PersonnelController extends Controller
{
    //
    public function index (){

        return view('personnel.index');
    }

    public function store (Request $request){
        

        return view('personnel.index');
    }
}
