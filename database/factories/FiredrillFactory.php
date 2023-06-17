<?php

namespace Database\Factories;

use App\Models\Firedrill;
use App\Models\Receipt;
use DateTime;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Firedrill>
 */
class FiredrillFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Firedrill::class;
    
    private static $controlNumber;

    public function definition(): array
    {
        $newDate = HelperFactory::randomDate(2019,2022,01,04);

        $dateClaimed = HelperFactory::randomDate($newDate->format('Y'),$newDate->format('Y'),$newDate->format('m'));

        if (!isset(self::$controlNumber)) {
            self::$controlNumber = Firedrill::count() + 1;
        }

        if(rand(0,2) == 0)
        {
            return [
                //
                'control_no' => $newDate->format('Y').'-CCFO-'.(sprintf("%04d",self::$controlNumber++)),
                'validity_term' => '1ST QUARTER',
                'date_claimed' => $newDate->format('Y-m-d'),
                'issued_on' => $newDate->format('Y-m-d'),
                'date_made' => $newDate->format('Y-m-d'),
                'term_type' => 'QUARTER',
                'claimed_by' => strtoupper(fake()->firstName()).' '.strtoupper(fake()->lastName()),
                'year' => $newDate->format('Y'),
                'establishment_id' => rand(1,HelperFactory::$establishmentCount),
                'receipt_id' => Receipt::factory()
            ];
        }
        else
        {
            return [
                //
                'control_no' => $newDate->format('Y').'-CCFO-'.(sprintf("%04d",self::$controlNumber++)),
                'validity_term' => '1ST QUARTER',
                'date_claimed' => null,
                'issued_on' => $newDate->format('Y-m-d'),
                'date_made' => $newDate->format('Y-m-d'),
                'term_type' => 'QUARTER',
                'claimed_by' => null,
                'year' => $newDate->format('Y'),
                'establishment_id' => rand(1,HelperFactory::$establishmentCount),
                'receipt_id' => Receipt::factory()
            ];
        }
    }
}
