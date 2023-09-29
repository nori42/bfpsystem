<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ActivityController extends Controller
{
    
    //
    public function index(Request $request){
        function getActivityLogsOf($activityIn,$dates){
            return DB::table('activities')
            ->join('users','users.id','=','activities.user_id')
            ->join('personnel','personnel.id','=','users.personnel_id')
            ->select('activities.activity','users.name','activities.created_at','users.type','personnel.first_name','personnel.last_name')
            ->where('activities.activity_in',$activityIn)
            ->whereBetween('activities.created_at',[$dates['from'],$dates['to'].' 23:59:59'])
            ->orderBy('activities.created_at','desc')
            ->get();
        }

        function allActivities(){
            return DB::table('activities')
            ->join('users','users.id','=','activities.user_id')
            ->join('personnel','personnel.id','=','users.personnel_id')
            ->select('activities.activity','users.name','activities.created_at','users.type','personnel.first_name','personnel.last_name')
            ->whereDate('activities.created_at',date('Y-m-d'))
            ->orderBy('activities.created_at','desc')
            ->get();
        }
        
        $dateFrom = date('Y-m-d',strtotime($request->dateFrom));
        $dateTo = date('Y-m-d',strtotime($request->dateTo));
        
        if(date('Y-m-d',strtotime($request->dateFrom)) > date('Y-m-d',strtotime($request->dateTo)))
        {   
            $errorMssg = "The selected date range is invalid.";
            return redirect()->back()->with('toastMssg',$errorMssg);
        }
        

        //Initial load on activity log
        if($request->dateFrom == null && $request->dateTo == null)
        {
            // All Activities
            $activities = allActivities();


            return view('activityLog',[
                'activities' => $activities,
                // 'dateRange' => [$request->activityDateFrom,$request->activityDateTo],
                'dateRange' => ['from' => $request->dateFrom, 'to' => $request->dateTo],
                'dateQuery' => date('Y-m-d'),
                'activityIn' => ""
            ]);
        }


        //To include the dateTo activities
        $dateTo = $dateTo.' 23:59:59';
        error_log($dateTo);

        switch ($request->activityIn) {
            case 'FSIC':
                    $activities = getActivityLogsOf("FSIC",["from" => $dateFrom, "to" => $dateTo]);
                break;
            case 'FSEC':
                    $activities = getActivityLogsOf("FSEC",["from" => $dateFrom, "to" => $dateTo]);
                break;
            case 'FIREDRILL':
                    $activities = getActivityLogsOf("FIREDRILL",["from" => $dateFrom, "to" => $dateTo]);   
                break;
            case 'USERS':
                    $activities = getActivityLogsOf("USERS",["from" => $dateFrom, "to" => $dateTo]);
                break;
            case 'ALL':
                    $activities = allActivities();
                break;
            default:
                    $activities = DB::table('activities')
                    ->join('users','users.id','=','activities.user_id')
                    ->join('personnel','personnel.id','=','users.personnel_id')
                    ->select('activities.activity','users.name','activities.created_at','users.type','personnel.first_name','personnel.last_name')
                    ->whereBetween('activities.created_at',[$dateFrom,$dateTo])
                    ->orderBy('activities.created_at','desc')
                    ->get();
                break;
        }


        return view('activityLog',[
            'activities' => $activities,
            // 'dateRange' => [$request->activityDateFrom,$request->activityDateTo],
            'dateRange' => ['from' => $request->dateFrom, 'to' => $request->dateTo],
            'activityIn' => $request->activityIn
        ]);
    }
}
