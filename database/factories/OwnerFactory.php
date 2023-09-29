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
   
    
    private static $seriesNo;

    public function definition(): array
    {    

        if(rand(0,3) == 0){
            $compName = strtoupper(fake()->company());
        }
        else{
            $compName = null;
        }
        return [
            'first_name' => strtoupper(fake()->firstName()),
            'middle_name' => strtoupper(fake()->lastName()),
            'last_name' => strtoupper(fake()->lastName()),
            'contact_no' => fake()->phoneNumber,
            'corporate_name' => $compName
        ];
    }
}
