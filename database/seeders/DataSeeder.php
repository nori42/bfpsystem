<?php

namespace Database\Seeders;

use App\Models\BuildingPlan;
use App\Models\Establishment;
use App\Models\Firedrill;
use App\Models\Inspection;
use Database\Factories\HelperFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Establishment::factory()->count(50)->create();
        BuildingPlan::factory()->count(50)->create();
    }
}
