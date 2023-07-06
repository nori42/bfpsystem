<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class FirstAdmin extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        \App\Models\User::create([
            'username' => 'adminDev',
            'password' => Hash::make('Bfpadmin01'),
            'name' => 'DEVELOPER',
            'request_password_reset' => false,
            'is_password_default' => false,
            'type' => "ADMINISTRATOR",
        ]);
    }
}
