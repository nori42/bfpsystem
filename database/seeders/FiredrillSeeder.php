<?php

namespace Database\Seeders;

use App\Models\Firedrill;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FiredrillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Firedrill::factory()->count(200)->create();
    }
}
