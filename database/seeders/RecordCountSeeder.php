<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RecordCountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        \App\Models\User::create([
            'record_name' => 'fsic',
            'count' => 0        
        ]);

        \App\Models\User::create([
            'record_name' => 'fsec',
            'count' => 0        
        ]);

        \App\Models\User::create([
            'record_name' => 'firedrill',
            'count' => 0        
        ]);
    }
}
