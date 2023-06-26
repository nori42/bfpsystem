<?php

namespace Database\Factories;

use App\Models\Establishment;
use App\Models\Inspection;
use App\Models\Receipt;
use DateInterval;
use DateTime;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Inspection>
 */
class InspectionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Inspection::class;

    public function definition(): array
    {
        $randomDay = rand(1, 28); // Generate a random day between 1 and 28
        $randomMonth = rand(1, 12); // Generate a random month between 1 and 12
        $randomYear = rand(2019, 2021); // Generate a random year between 1900 and 2023

        $dateInsp = new DateTime();
        $dateInsp->setDate($randomYear, $randomMonth, $randomDay);

        $registrationStatus = array('NEW','RENEWAL','OCCUPANCY','ACCREDITATION','BUILDING PERMIT');
        if(rand(0,5) == 0){

            return [
                //
                'inspection_date' => HelperFactory::randomDate(2019,2022,01,04),
                'registration_status' => $registrationStatus[rand(0, 4)],
                'fsic_no' => rand(1000, 99999),
                'user_id' => 1,
                'receipt_id' => Receipt::factory(),
                'establishment_id' => rand(1,HelperFactory::$establishmentCount)
            ];
    
        }
        else
        {

            // $randomDay = rand(1, 28); // Generate a random day between 1 and 28
            // $randomMonth = rand(1, 12); // Generate a random month between 1 and 12
            // $randomYear = rand(2019, 2022); // Generate a random year between 1900 and 2022
            // $nextYear = $randomYear + 1;
            // $date = new DateTime();
            // $date->setDate($randomYear, $randomMonth, $randomDay);

            $date = HelperFactory::randomDate(2019,2022,01,04);

            $nextYear = $date->format('Y') + 1;
            
            return [
                //
                'inspection_date' => $dateInsp,
                'registration_status' => $registrationStatus[rand(0, 4)],
                'fsic_no' => rand(1000, 99999),
                'user_id' => 1,
                'issued_on' => $date,
                'status' => "Printed",
                'expiry_date' =>new DateTime("{$nextYear}-{$date->format('m')}-{$date->format('d')}"),
                'receipt_id' => Receipt::factory(),
                'establishment_id' => rand(1,100)
            ];
        }
    }
}
