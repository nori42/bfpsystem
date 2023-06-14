<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Establishment;
use App\Models\Firedrill;
use App\Models\Inspection;
use App\Models\Owner;
use Database\Factories\HelperFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        \App\Models\User::create([
            'username' => 'admin01',
            'password' => Hash::make('admin'),
            'name' => 'admin',
            'type' => strtoupper('admin'),
        ]);

        Establishment::factory()->count(HelperFactory::$establishmentCount)->create();
        Inspection::factory()->count(50)->create();
    }
}