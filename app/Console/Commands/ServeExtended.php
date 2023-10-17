<?php

namespace App\Console\Commands;

use App\Models\BuildingPlan;
use App\Models\Establishment;
use App\Models\Inspection;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Foundation\Console\ServeCommand;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ServeExtended extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'serve:startUpConfig';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setting server configuration.';

    /**
     * Execute server configuration.
     */
    public function handle(): void
    {
        //
        //Update establishments that has expired inspections
        $inspections = Inspection::whereDate('expiry_date','>=',now()->subDay(5))->whereDate('expiry_date','<=',now())->get();

        foreach ($inspections as $inspection) {
            $establishment = $inspection->establishment;
            $latestInspection = $establishment->inspection->last();

            //Only update if the latest inspection of the establishment is expired
            if(date('Y-m-d',strtotime($latestInspection->expiry_date)) == date('Y-m-d')){
                $establishment->inspection_is_expired = true;
            }

            $inspection->status = "Expired";

            $establishment->save();
            $inspection->save();
        };

        //remove from database all deleted model after 30 days
        Establishment::onlyTrashed()->whereDate('deleted_at','<=',now()->subDays(30))->forceDelete();
        User::onlyTrashed()->whereDate('deleted_at','<=',now()->subDays(30))->forceDelete();
        BuildingPlan::onlyTrashed()->whereDate('deleted_at','<=',now()->subDays(30))->forceDelete();
        
        // Check for the firedrills
        switch(date('F-d',time())){
            case 'January-01':
                    DB::table('establishments')
                    ->update(['firedrill_is_expired'=> true]);
                break;
            case 'April-01':

                    DB::table('establishments')
                    ->where('firedrill_type','QUARTERLY')
                    ->where('firedrill_count_yearly','<',2)
                    ->update(['firedrill_is_expired' => true]);

                break;
            case 'July-01':
                    // Check for quarterly firedrill
                    DB::table('establishments')
                    ->where('firedrill_type','QUARTERLY')
                    ->where('firedrill_count_yearly','<',3)
                    ->update(['firedrill_is_expired' => true]);

                    // Check for semesterly firedrill
                    DB::table('establishments')
                    ->where('firedrill_type','SEMESTER')
                    ->where('firedrill_count_yearly','<',2)
                    ->update(['firedrill_is_expired' => true]);
                break;
            case 'October-01':
                    DB::table('establishments')
                    ->where('firedrill_type','QUARTERLY')
                    ->where('firedrill_count_yearly','<',4)
                    ->update(['firedrill_is_expired' => true]);
                break;
            }

            // Execute the serve command
            // Artisan::call('serve');

            error_log("Server Configured");
            // Log::info("Server started");
    }
}
