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
        $issuedFor = array('NEW BUSINESS PERMIT','THE PURPOSE OF SECURING BUSINESS PERMIT','OCCUPANCY PERMIT','RENEWAL OF BUSINESS PERMIT');
        if(true){

            $date = HelperFactory::randomDate(2023,2023,7,9);

            return [
                //
                'inspection_date' => $date,
                'registration_status' => $registrationStatus[0],
                'issued_for' => $issuedFor[0],
                'issued_on' => $date,
                'status' => 'Printed',
                'fsic_no' => rand(1000, 99999),
                'user_id' => 1,
                'receipt_id' => Receipt::factory(),
                'establishment_id' => rand(1,100)
            ];
    
        }
        else
        {

            $date = HelperFactory::randomDate(2022,2022,9,9);

            $nextYear = $date->format('Y') + 1;
            $expiry_date = new DateTime("{$nextYear}-{$date->format('m')}-{$date->format('d')}");
            
            return [
                //
                'inspection_date' => HelperFactory::randomDate(2022,2022,8,8),
                'registration_status' => $registrationStatus[rand(0, 4)],
                'fsic_no' => rand(1000, 99999),
                'user_id' => 1,
                'issued_on' => $date,
                'status' => $expiry_date <= now()?"Expired":"Printed",
                'expiry_date' => $expiry_date,
                'receipt_id' => Receipt::factory(),
                'establishment_id' => rand(500,600)
            ];
        }
    }
}
