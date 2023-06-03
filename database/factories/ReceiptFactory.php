<?php

namespace Database\Factories;

use App\Models\Receipt;
use DateTime;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Receipt>
 */
class ReceiptFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Receipt::class;
    public function definition(): array
    {

        $randomDay = rand(1, 28); // Generate a random day between 1 and 28
        $randomMonth = rand(1, 12); // Generate a random month between 1 and 12
        $randomYear = rand(2020, 2022); // Generate a random year between 1900 and 2023

        $date = new DateTime();
        $date->setDate($randomYear, $randomMonth, $randomDay);

        return [
            'or_no' => rand(1000,99999),
            'amount' => rand(1000,10000),
            'date_of_payment' => $date,
            'receipt_for' => 'Fire Safety Inspection Certificate(FSIC)',
        ];
    }
}
