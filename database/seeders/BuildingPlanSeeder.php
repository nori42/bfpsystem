<?php

namespace Database\Seeders;

use App\Models\BuildingPlan;
use App\Models\Evaluation;
use Database\Factories\EvaluationFactory;
use Database\Factories\HelperFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BuildingPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    // Execute this sql commands to delete all duplicate approved
    //  DELETE FROM your_table
    // WHERE remarks = 'APPROVED' AND id NOT IN (
    //     SELECT MIN(id)
    //     FROM your_table
    //     WHERE remarks = 'APPROVED'
    //     GROUP BY building_plan_id
    //   );

    public function run(): void
    {
        //
        BuildingPlan::factory()->count(HelperFactory::$buildingPlanCount)->create();
        // Evaluation::factory()->count(200)->create();
    }
}
