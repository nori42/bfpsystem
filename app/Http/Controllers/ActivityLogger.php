<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

enum Activity{
    case AddEstablishment;
    case UpdateEstablishment;
    case AddInspection;
    case PrintInspection;
    case AddFiredrill;
    case PrintFiredrill;
    case AddBuildingPlan;
    case UpdateBuildingPlan;
    case DisapporveBuildingPlan;
    case ApproveBuildingPlan;
}

class ActivityLogger {

    public static function establishmentLog($establishmentName,Activity $activity){
        
        $activity_in = "ESTABLISHMENT";

        switch($activity)
        {
            case Activity::AddEstablishment:
                {   
                    $activityLog = "Added the {$establishmentName} establishment";

                    DB::table('activities')->insert([
                        'activity' => $activityLog,
                        'user_id' => auth()->user()->id,
                        'activity_in' => $activity_in,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
            break;
            case Activity::UpdateEstablishment:
                {
                    $activityLog = "Updated the {$establishmentName} establishment";

                    DB::table('activities')->insert([
                        'activity' => $activityLog,
                        'user_id' => auth()->user()->id,
                        'activity_in' => $activity_in,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
        }
    }

    public static function fsicLog($establishmentName,Activity $activity){

        $activity_in = "FSIC";

        switch($activity)
        {
            case Activity::AddInspection:
                {   
                    $activityLog = "Added new Inspection to {$establishmentName}";

                    DB::table('activities')->insert([
                        'activity' => $activityLog,
                        'user_id' => auth()->user()->id,
                        'activity_in' => $activity_in,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
            break;
            case Activity::PrintInspection:
                {
                    $activityLog = "Printed a Fire Safety Inspection Certificate for {$establishmentName}";

                    DB::table('activities')->insert([
                        'activity' => $activityLog,
                        'user_id' => auth()->user()->id,
                        'activity_in' => $activity_in,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
        }
    }

    public static function firedrillLog($establishmentName,Activity $activity)
    {
        $activity_in = "FIREDRILL";

        switch($activity)
        {
            case Activity::AddFiredrill:
                {   
                    $activityLog = "Added new Firedrill to {$establishmentName}";

                    DB::table('activities')->insert([
                        'activity' => $activityLog,
                        'user_id' => auth()->user()->id,
                        'activity_in' => $activity_in,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
            break;
            case Activity::PrintFiredrill:
                {
                    $activityLog = "Printed a Firedrill Certificate for {$establishmentName}";

                    DB::table('activities')->insert([
                        'activity' => $activityLog,
                        'user_id' => auth()->user()->id,
                        'activity_in' => $activity_in,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
        }
    }

    public static function buildingPlanLog($buildingPlanApplicant,Activity $activity)
    {
        $activity_in = "FSEC";

        switch($activity)
        {
            case Activity::AddBuildingPlan:
                {   
                    $activityLog = "Added new Building Plan Application for {$buildingPlanApplicant}";

                    DB::table('activities')->insert([
                        'activity' => $activityLog,
                        'user_id' => auth()->user()->id,
                        'activity_in' => $activity_in,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
            break;
            case Activity::UpdateBuildingPlan:
                {
                    $activityLog = "Updated the Building Plan Application of {$buildingPlanApplicant}";

                    DB::table('activities')->insert([
                        'activity' => $activityLog,
                        'user_id' => auth()->user()->id,
                        'activity_in' => $activity_in,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
                break;
            case Activity::ApproveBuildingPlan:
                {
                    $activityLog = "Approve the Building Plan Application of {$buildingPlanApplicant}";

                    DB::table('activities')->insert([
                        'activity' => $activityLog,
                        'user_id' => auth()->user()->id,
                        'activity_in' => $activity_in,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
            break;
            case Activity::DisapporveBuildingPlan:
                {
                    $activityLog = "Disapprove the Building Plan Application of {$buildingPlanApplicant}";

                    DB::table('activities')->insert([
                        'activity' => $activityLog,
                        'user_id' => auth()->user()->id,
                        'activity_in' => $activity_in,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
            break;
        }
    }

    public static function logActivity($userId,$activity,$type){
        DB::table('activities')->insert([
            'activity' => $activity,
            'user_id' => $userId,
            'activity_in' => $type,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}