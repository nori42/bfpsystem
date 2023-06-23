<?php

namespace Database\Factories;
use DateTime;

class HelperFactory {

    public static $establishmentCount = 1000;
    public static $buildingPlanCount = 200;

    public static function randomDate($minYear = 2019,$maxYear = 2023,$minMonth = 01, $maxMonth = 12){
        $randomDay = rand(1, 28); // Generate a random day between 1 and 28
        $randomMonth = rand($minMonth, $maxMonth); // Generate a random month between 1 and 12
        $randomYear = rand($minYear, $maxYear); // Generate a random year between 1900 and 2023

        $newDate = new DateTime();
        $newDate->setDate($randomYear, $randomMonth, $randomDay);

        return $newDate;
    }
}