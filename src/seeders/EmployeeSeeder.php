<?php

namespace seeders;

use \models\Hotel as Hotel;
use \models\Employee as Employee;
use \models\DB as DB;

class EmployeeSeeder extends Seeder {

    public static function run($num) {
        header('Content-type: text/plain');
        // Set default timezone to UTC for proper time calculations
        $tz = date_default_timezone_get();
        date_default_timezone_set('UTC');
        $hotels = Hotel::all();
        $keys_works = ['Employee_IRS', 'Hotel_ID', 'Start_Date', 'Finish_Date', 'Position'];
        for($n = 0; $n < $num; ++$n) {
            $irs = self::generateIRS();
            $ssn = self::generateSSN();
            $positions = [];
            while(count($positions) < 20) {
                $p = self::generatePosition();
                if(!in_array($p, $positions)) {
                    $positions = array_merge($positions, array_fill(0, rand(5, 20), $p));
                }
            }
            shuffle($positions);
            $data = array_merge([
                'emp_IRS' => $irs,
                'SSN' => $ssn
            ], self::generatePerson());
            $query = Employee::create($data);
            if($query) {
                /* From 2000-01-01 */
                $start = rand(946684800, time());
                while(intdiv($start, 86400) < intdiv(time(), 86400)) {
                    $hotel_id = $hotels[rand(0, count($hotels) - 1)]->id;
                    /* Random duration from 0 to 5 years */
                    $duration = rand(1, 157784630);
                    $values = '(' . join(', ', [
                        $irs,
                        $hotel_id,
                        'DATE(\'' . date('Y-m-d', $start) . '\')',
                        'DATE(\'' . date('Y-m-d', $start + $duration) . '\')',
                        '\'' . $positions[rand(0, count($positions) - 1)] . '\''
                    ]) . ')';
                    $query = DB::query('INSERT INTO Works(' . join(', ', $keys_works) . ') VALUES ' . $values);
                    if($query) {
                        /* Start from next day */
                        $start = (intdiv($start + $duration, 86400) + 1) * 86400;
                    } else {
                        echo DB::error(), "\n";
                    }
                }
            } else {
                echo DB::error(), "\n";
            }
        }
        date_default_timezone_set($tz);
    }

}