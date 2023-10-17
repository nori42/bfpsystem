<?php

namespace App\Http\Controllers;

use App\Models\FireIncident;
use Illuminate\Http\Request;

class FireIncidentsController extends Controller
{
    //
    public function index() {
        
        $fireincidents = FireIncident::orderBy('date_of_incident','desc')->get();
        return view('fireincidents',[
            'fireincidents' => $fireincidents
        ]);
    }

    public function store(Request $request){
        
        $fireincident = new FireIncident();

        $fireincident->barangay = strtoupper($request->location);
        $fireincident->substation = $request->substation;
        $fireincident->date_of_incident = $request->dateOfIncident;
        $fireincident->save();

        return redirect('/fireincidents')->with('mssg',"New Record Added");
    }

    public function destroy(Request $request){
        error_log($request->deletionId);
        $fireincident = FireIncident::find($request->deletionId);
        $fireincident->delete();
        return redirect('/fireincidents')->with('mssg',"Record Deleted");
    }
}
