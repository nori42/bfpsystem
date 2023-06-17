<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Building>
 */
class BuildingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'occupancy' => 'RESIDENTIAL',
            'sub_type' => 'HOTEL',
            'height' => '3',
            'building_story' => '3',
            'floor_area' => '5',
            'address' => 'CEBU CITY'
        ];
    }
}
