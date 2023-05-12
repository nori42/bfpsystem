<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Person>
 */
class PersonFactory extends Factory
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
            'first_name' => strtoupper(fake()->firstName()),
            'middle_name' => strtoupper(fake()->lastName()),
            'last_name' => strtoupper(fake()->lastName()),
            'contact_no' => fake()->phoneNumber
        ];
    }
}
