<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

enum Activity{
    case AddEstablishment;
    case DeleteEstablishment;
    case UpdateEstablishment;
    case AddInspection;
    case PrintInspection;
    case AddFiredrill;
    case PrintFiredrill;
    case AddBuildingPlan;
    case UpdateBuildingPlan;
    case DisapporveBuildingPlan;
    case ApproveBuildingPlan;
    case DeleteBuildingPlan;
    case AddUser;
    case DeleteUser;
}

class ActivityLogger {
    public static function logActivity($log,$activityIn){
        DB::table('activities')->insert([
            'activity' => $log,
            'user_id' => auth()->user()->id,
            'activity_in' => $activityIn,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }

    public static function establishmentLog($establishmentName,Activity $activity){
        
        $activity_in = "ESTABLISHMENT";

        switch($activity)
        {
            case Activity::AddEstablishment:
                {   
                    $activityLog = "Added new establishment: {$establishmentName}";

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
                    $activityLog = "Updated the establishment: {$establishmentName}";

                    DB::table('activities')->insert([
                        'activity' => $activityLog,
                        'user_id' => auth()->user()->id,
                        'activity_in' => $activity_in,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
            break;
            case Activity::DeleteEstablishment:
                {
                    $activityLog = "Deleted the establishment: {$establishmentName} ";

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

    public static function fsicLog($establishmentName,Activity $activity){

        $activity_in = "FSIC";

        switch($activity)
        {
            case Activity::AddInspection:
                {   
                    $activityLog = "Added new inspection: {$establishmentName}";

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
                    $activityLog = "Issued a Fire Safety Inspection Certificate: {$establishmentName}";

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
                    $activityLog = "Issued a Firedrill Certificate: {$establishmentName}";

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
                    $activityLog = "Added new Building Plan Applicant: {$buildingPlanApplicant}";

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
                    $activityLog = "Updated the Building Plan Application: {$buildingPlanApplicant}";

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
                    $activityLog = "Approve the Building Plan Application: {$buildingPlanApplicant}";

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
                    $activityLog = "Disapproved the Building Plan Application: {$buildingPlanApplicant}";

                    DB::table('activities')->insert([
                        'activity' => $activityLog,
                        'user_id' => auth()->user()->id,
                        'activity_in' => $activity_in,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
            break;

            case Activity::DeleteBuildingPlan:
                {
                    $activityLog = "Deleted the Building Plan Application: {$buildingPlanApplicant}";

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

    public static function userLog($userId,$userType,$username){
        $activityLog = "Added a new user, Username:{$username} Type:{$userType}";

        DB::table('activities')->insert([
            'activity' => $activityLog,
            'user_id' => $userId,
            'activity_in' => "USER",
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}