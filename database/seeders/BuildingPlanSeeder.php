<?php

namespace Database\Seeders;

use App\Models\BuildingPlan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BuildingPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        BuildingPlan::factory()->count(100)->create();
    }
}
