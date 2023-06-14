<?php

namespace Database\Seeders;

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
        Establishment::factory()->count(HelperFactory::$establishmentCount)->create();
        Inspection::factory()->count(1000)->create();
        Firedrill::factory()->count(1000)->create();
    }
}
