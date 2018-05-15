<?php

namespace seeders;

use \models\Hotel as Hotel;
use \models\Employee as Employee;
use \models\DB as DB;

class EmployeeSeeder extends Seeder {

    public static function run($num, $onlySQL = false) {
        header('Content-type: text/plain');
        $hotels = Hotel::all();
        $keys_employees = [];
        $insert_employees = [];
        $keys_works = ['Employee_IRS', 'Hotel_ID', 'Start_Date', 'Finish_Date', 'Position'];
        $insert_works = [];
        for($n = 0; $n < $num; ++$n) {
            $irs = self::generateIRS();
            $ssn = self::generateSSN();
            $data = array_merge([
                'emp_IRS' => $irs,
                'SSN' => $ssn
            ], self::generatePerson());
            $db_clauses = Employee::getDBClausesInsert($data);
            if(!$onlySQL) {
                $query = Employee::create($data);
            }
            if($onlySQL || $query) {
                $keys_employees = $db_clauses['insert'];
                $insert_employees[] = '(' . join(', ', $db_clauses['values']) . ')';
                /* From 2000-01-01 */
                $start = rand(946684800, time());
                while(intdiv($start, 86400) < intdiv(time(), 86400)) {
                    $hotel_id = $hotels[rand(0, count($hotels) - 1)]->id;
                    /* Random duration from 0 to 5 years */
                    $duration = rand(0, 157784630);
                    $values = '(' . join(', ', [
                        $irs,
                        $hotel_id,
                        'DATE(\'' . date('Y-m-d', $start) . '\')',
                        'DATE(\'' . date('Y-m-d', $start + $duration) . '\')',
                        '\'' . self::generatePosition() . '\''
                    ]) . ')';
                    $insert_works[] = $values;
                    if(!$onlySQL) {
                        $query = DB::query('INSERT INTO Works(' . join(', ', $keys_works) . ') VALUES ' . $values);
                    }
                    if($onlySQL || $query) {
                        $start += $duration;
                        /* Start from next day */
                        $start = (intdiv($start - 1, 86400) + 1) * 86400;
                    }
                }
            }
        }
        if(count($insert_employees)) {
            echo "-- Employees\n\n";
            echo 'INSERT INTO Employee(' . join(', ', $keys_employees) . ') VALUES' . "\n" . join(",\n", $insert_employees) . ";\n\n";
        }
        if(count($insert_works)) {
            echo "-- Works\n\n";
            echo 'INSERT INTO Works(' . join(', ', $keys_works) . ') VALUES' . "\n" . join(",\n", $insert_works) . ";\n\n";
        }
    }

}