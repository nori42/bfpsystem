<?php

namespace Database\Factories;

use App\Http\Controllers\Helper;
use App\Models\Evaluation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Evaluation>
 */
class EvaluationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

     protected $model = Evaluation::class;

    public function definition(): array
    {
        $remarks = rand(1,2);
        $buildingPlanId = rand(1,HelperFactory::$buildingPlanCount);
        $rand_date =  HelperFactory::randomDate(2019,2022,01,06);

        return [
            'evaluator' => 'ADMIN',
            'remarks' => $remarks == 1 ? 'APPROVED': 'DISAPPROVED',
            'building_plan_id' => $buildingPlanId,
            'created_at' => $rand_date,
            'updated_at' => $rand_date
        ];
    }   
}
