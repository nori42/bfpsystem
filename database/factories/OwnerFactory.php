<?php

namespace Database\Factories;

use App\Models\Corporate;
use App\Models\Owner;
use App\Models\Person;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Owner>
 */
class OwnerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
   
    


    public function definition(): array
    {       
        return [
            'person_id' => Person::factory(),
            'corporate_id' => Corporate::factory()
        ];
    }
}
