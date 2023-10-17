<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Database\Query\Builder;
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
            ->select('activities.activity','users.name','activities.activity_in','activities.created_at','users.type','personnel.first_name','personnel.last_name')
            ->where('activities.activity_in',$activityIn)
            ->whereBetween('activities.created_at',[$dates['from'],$dates['to'].' 23:59:59'])
            ->orderBy('activities.created_at','desc')
            ->get();
        }

        function getActivityLogsOfFSIC($dates){
            return DB::table('activities')
            ->join('users','users.id','=','activities.user_id')
            ->join('personnel','personnel.id','=','users.personnel_id')
            ->select('activities.activity','users.name','activities.activity_in','activities.created_at','users.type','personnel.first_name','personnel.last_name')
            ->whereBetween('activities.created_at',[$dates['from'],$dates['to'].' 23:59:59'])
            ->where(function (Builder $query){
                $query->where('activities.activity_in', 'FSIC')
                      ->orWhere('activities.activity_in', 'ESTABLISHMENT');
            })
            // ->where('activities.created_at',[$dates['from'].' 23:59:59'])
            ->orderBy('activities.created_at','desc')
            ->get();
        }

        function allActivities($dates){
            return DB::table('activities')
            ->join('users','users.id','=','activities.user_id')
            ->join('personnel','personnel.id','=','users.personnel_id')
            ->select('activities.activity','users.name','activities.activity_in','activities.created_at','users.type','personnel.first_name','personnel.last_name')
            ->whereBetween('activities.created_at',[$dates['from'],$dates['to'].' 23:59:59'])
            ->orderBy('activities.created_at','desc')
            ->get();
        }
        

        if($request->dateFrom == null) {
            $dateFrom = date('Y-m-d');
            $dateTo = date('Y-m-d');
        } else {
            $dateFrom = date('Y-m-d',strtotime($request->dateFrom));
            $dateTo = date('Y-m-d',strtotime($request->dateTo));
        }
        
        // If date from is greater than the date to
        if(date('Y-m-d',strtotime($request->dateFrom)) > date('Y-m-d',strtotime($request->dateTo)))
        {   
            $errorMssg = "The selected date range is invalid.";
            return redirect()->back()->with('toastMssg',$errorMssg);
        }

        

        //Initial load on activity log
        if($request->dateFrom == null && $request->dateTo == null)
        {
            // All Activities
            $activities = allActivities(["from" => $dateFrom, "to" => $dateTo]);


            return view('activityLog',[
                'activities' => $activities,
                // 'dateRange' => [$request->activityDateFrom,$request->activityDateTo],
                'dateRange' => ['from' => $request->dateFrom, 'to' => $request->dateTo],
                'dateQuery' => date('Y-m-d'),
                'activityIn' => ""
            ]);
        }


        //To include the dateTo activities
        // $dateTo = $dateTo.' 23:59:59';

        
        // error_log('From:'.$dateFrom);
        // error_log('To:'.$dateTo);

        switch ($request->activityIn) {
            case 'FSIC':
                    $activities = getActivityLogsOfFSIC(["from" => $dateFrom, "to" => $dateTo]);
                break;
            case 'FSEC':
                    $activities = getActivityLogsOf("FSEC",["from" => $dateFrom, "to" => $dateTo]);
                break;
            case 'FIREDRILL':
                    $activities = getActivityLogsOf("FIREDRILL",["from" => $dateFrom, "to" => $dateTo]);   
                break;
            case 'USERS':
                    $activities = getActivityLogsOf("USER",["from" => $dateFrom, "to" => $dateTo]);
                break;
            case 'ALL':
                    $activities = allActivities(["from" => $dateFrom, "to" => $dateTo]);
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
