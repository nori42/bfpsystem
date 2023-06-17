<?php

namespace Database\Factories;

use App\Models\Building;
use App\Models\BuildingPlan;
use App\Models\Owner;
use App\Models\Receipt;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BuildingPlan>
 */
class BuildingPlanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = BuildingPlan::class;

    private static $seriesNo;

    public function definition(): array
    {
        $status = ['APPROVED', 'DISAPPROVED'];

        if (!isset(self::$seriesNo)) {
            self::$seriesNo = BuildingPlan::count() + 1;
        }

        if(rand(0,5) == 0 )
        {
            $status = "APPROVED";
        }
        else{
            $status = "DISAPPROVED";
        }



        return [
            //
                'project_title' => 'Project Test',
                'name_of_building' => 'Building Name Test',
                'series_no' => (sprintf("%04d",self::$seriesNo++)).'-S\''.date('Y'),
                'bp_application_no' => random_int(1000,9999),
                'date_received' => date('Y-m-d'),
                'status' => $status,
                'owner_id' => Owner::factory(),
                'building_id' => Building::factory(),
                'receipt_id' => Receipt::factory()

        ];
    }
}
