<?php

namespace Database\Factories;

use App\Models\Establishment;
use App\Models\Owner;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Establishment>
 */
class EstablishmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * 
     * @return array<string, mixed>
     */
    protected $model = Establishment::class;

    public function definition(): array
    {
        $substations = array('CCSF','CPB','GUADALUPE','LABANGON','LAHUG','MABOLO','PAHINA CENTRAL','PARDO','PARI-AN','SAN NICOLAS','TALAMBAN');
        $building_type = array('SMALL', 'MEDIUM', 'LARGE', 'HIGH RISE');
        $occupancy = array('RESIDENTIAL','ASSEMBLY','EDUCATIONAL','MERCANTILE','DETENTION AND CORRECTIONAL','INDUSTRIAL', 'BUSINESS', 'STORAGE', 'OTHERS');

        $companyName = strtoupper(fake()->company());
        
        return [
            'establishment_name' => $companyName,
            'substation' => $substations[array_rand($substations)],
            'occupancy' => $occupancy[array_rand($occupancy)],
            'sub_type' => Str::random(10),
            'building_type' => $building_type[array_rand($building_type)],
            'occupancy' => $occupancy[array_rand($occupancy)],
            'no_of_storey' => random_int(1,5),
            'height' => random_int(1,15),
            'building_permit_no' => random_int(1000,9999),
            'fire_insurance_co' => strtoupper(fake()->company()),
            'latest_permit' => random_int(1000,9999),
            'barangay' => $substations[array_rand($substations)],
            'address' => $substations[array_rand($substations)].', '.'Cebu City',
            'owner_id' => Owner::factory(),
            'createdBy' => 'ADMIN'

        ];
    }
}
