<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ActivityController extends Controller
{
    //
    public function index(Request $request){
        $dateQuery = $request->activtyDate ? $request->activtyDate : date('Y-m-d');
        

        $activities = DB::table('activities')
        ->join('users','users.id','=','activities.user_id')
        ->select('activities.activity','users.name','activities.created_at','users.type')
        ->whereDate('activities.created_at',$dateQuery)
        ->orderBy('activities.created_at','desc')
        ->get();

        return view('activityLog',[
            'activities' => $activities,
            'dateQuery' => $dateQuery
        ]);
    }
}
