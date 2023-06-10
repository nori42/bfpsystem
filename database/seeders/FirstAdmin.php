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
            'username' => 'admin01',
            'password' => Hash::make('admin'),
            'name' => 'admin',
            'request_password_reset' => false,
            'type' => strtoupper('admin'),
        ]);
    }
}
