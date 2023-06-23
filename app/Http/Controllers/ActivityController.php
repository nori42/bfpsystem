<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ActivityController extends Controller
{
    //
    public function index(){
        $activities = DB::table('activities')
        ->join('users','users.id','=','activities.user_id')
        ->select('activities.activity','users.name','activities.created_at','users.type')
        ->orderBy('activities.created_at','desc')
        ->get();

        return view('activityLog',[
            'activities' => $activities
        ]);
    }
}
