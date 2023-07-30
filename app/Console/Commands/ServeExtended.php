<?php

namespace App\Console\Commands;

use App\Models\Inspection;
use Illuminate\Console\Command;
use Illuminate\Foundation\Console\ServeCommand;
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
        error_log('Info:Setting server configuration.');
        //Update establishments that has expired inspections
        $inspections = Inspection::where('expiry_date',date('Y-m-d'))->get();
        foreach ($inspections as $inspection) {
            $inspection->establishment->inspection_is_expired = true;
            $inspection->status = "Expired";
            $establishment = $inspection->establishment;

            $establishment->inspection_is_expired = true;

            $establishment->save();
            $inspection->save();
        };

        
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
    }
}
