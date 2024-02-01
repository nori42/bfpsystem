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
            $firstName = null;
            $lastName = null;
            $middleName = null;
        }
        else{
            $compName = null;
            $firstName = strtoupper(fake()->firstName());
            $middleName = strtoupper(fake()->lastName());
            $lastName = strtoupper(fake()->lastName());
        }
        return [
            'first_name' => $firstName,
            'middle_name' => $middleName,
            'last_name' => $lastName,
            'contact_no' => fake()->phoneNumber,
            'corporate_name' => $compName
        ];
    }
}
