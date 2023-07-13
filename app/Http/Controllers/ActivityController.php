<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ActivityController extends Controller
{
    //
    public function index(Request $request){
        if(date('Y-m-d',strtotime($request->activityDateFrom)) > date('Y-m-d',strtotime($request->activityDateTo)))
        {   
            $errorMssg = "The selected date range is invalid.";
            return redirect()->back()->with('toastMssg',$errorMssg);
        }
        
        //Initial load on activity log
        if($request->activityDateFrom == null && $request->activityDateTo == null)
        {
            $activities = DB::table('activities')
            ->join('users','users.id','=','activities.user_id')
            ->join('personnel','personnel.id','=','users.personnel_id')
            ->select('activities.activity','users.name','activities.created_at','users.type','personnel.first_name','personnel.last_name')
            ->whereDate('activities.created_at',date('Y-m-d'))
            ->orderBy('activities.created_at','desc')
            ->get();

            return view('activityLog',[
                'activities' => $activities,
                'dateRange' => [$request->activityDateFrom,$request->activityDateTo],
                'dateQuery' => date('Y-m-d')
            ]);
        }

        //With date range activity log
        
        $dateFrom = date('Y-m-d',strtotime($request->activityDateFrom));
        $dateTo = date('Y-m-d',strtotime($request->activityDateTo));

        //To include the dateTo activities
        $dateTo = $dateTo.' 23:59:59';

        $activities = DB::table('activities')
            ->join('users','users.id','=','activities.user_id')
            ->join('personnel','personnel.id','=','users.personnel_id')
            ->select('activities.activity','users.name','activities.created_at','users.type','personnel.first_name','personnel.last_name')
            ->whereBetween('activities.created_at',[$dateFrom,$dateTo])
            ->orderBy('activities.created_at','desc')
            ->get();

        return view('activityLog',[
            'activities' => $activities,
            'dateRange' => [$request->activityDateFrom,$request->activityDateTo]
        ]);
    }
}
