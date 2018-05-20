<?php

namespace seeders;

use \models\Hotel as Hotel;
use \models\Customer as Customer;
use \models\DB as DB;

class CustomerSeeder extends Seeder {

    public static function run($num) {
        // Set default timezone to UTC for proper time calculations
        $tz = date_default_timezone_get();
        date_default_timezone_set('UTC');
        while($num > 0) {
            $irs = self::generateIRS();
            $ssn = self::generateSSN();
            $first_registration = date('Y-m-d', rand(946684800, time()));
            $data = array_merge([
                'cust_IRS' => $irs,
                'SSN' => $ssn,
            ], self::generatePerson());
            $data['first_registration'] = $first_registration;
            $query = Customer::create($data);
            if($query) {
                --$num;
            }
        }
        date_default_timezone_set($tz);
    }

}