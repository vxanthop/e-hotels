<?php

namespace seeders;

use \models\Hotel as Hotel;
use \models\Employee as Employee;
use \models\DB as DB;

class ManagerSeeder extends Seeder {

    public static function run() {
        header('Content-type: text/plain');
        // Set default timezone to UTC for proper time calculations
        $tz = date_default_timezone_get();
        date_default_timezone_set('UTC');
        $keys_works = ['Employee_IRS', 'Hotel_ID', 'Start_Date', 'Finish_Date', 'Position'];
        $hotels = Hotel::all();
        foreach($hotels as $hotel) {
            /* Find first employee that worked in this hotel */
            $query = DB::query('SELECT * FROM Works WHERE Hotel_ID = ' . $hotel->id . ' ORDER BY Start_Date LIMIT 1');
            $first_employee = $query->fetch_assoc();
            if(!$first_employee) {
                echo 'Hotel never had any employees. Creating a new one in manager position.', "\n";
                $irs = self::generateIRS();
                $data = array_merge([
                    'emp_IRS' => $irs,
                    'SSN' => self::generateSSN(),
                ], self::generatePerson());
                $create = Employee::create($data);
                if(!$create) {
                    die(DB::error() . "\n");
                }
                $values = '(' . join(', ', [
                    $irs,
                    $hotel->id,
                    'DATE(\'' . date('Y-m-d', rand(time() - 31536000, time() - 86400)) . '\')',
                    'DATE(\'' . date('Y-m-d', rand(time(), time() + 31536000)) . '\')',
                    '\'manager\''
                ]) . ')';
                $query = DB::query('INSERT INTO Works(' . join(', ', $keys_works) . ') VALUES ' . $values);
                if(!$query) {
                    die(DB::error() . "\n");
                } else {
                    continue;
                }
            }
            echo "First employee: (", $first_employee['Start_Date'], ", ", $first_employee['Employee_IRS'], ", ", $first_employee['Position'], ")\n";
            /* Make them a manager */
            $query = DB::query('UPDATE Works SET Position = \'manager\' WHERE Employee_IRS = ' . $first_employee['Employee_IRS'] . ' AND Start_Date = DATE(\'' . $first_employee['Start_Date'] . '\')');
            if(!$query) {
                die(DB::error() . "\n");
            }
            /* Next date that needs to have an employee starting to work as a manager on that date */
            $next_date = strtotime('+1 day', strtotime($first_employee['Finish_Date']));
            /* Continue until all periods until current time are filled with managers */
            while(intdiv($next_date, 86400) < intdiv(time(), 86400)) {
                echo "Next date: ", date('Y-m-d', $next_date), "\n";
                /* Check if an overlapping employee exists */
                $overlap = DB::query('SELECT * FROM Works WHERE Hotel_ID = ' . $hotel->id . ' AND DATE(\'' . date('Y-m-d', $next_date) . '\') BETWEEN Start_Date AND Finish_Date ORDER BY Start_Date DESC LIMIT 1');
                $overlap_employee = $overlap->fetch_assoc();
                /* If not, create a new one on this particular period */
                if(!$overlap_employee) {
                    echo "No overlap found for ", date('Y-m-d', $next_date), ". Creating a new employee.\n";
                    /* Find min finish date until an employee exists that starts to work then */
                    $next_employee = DB::query('SELECT * FROM Works WHERE Hotel_ID = ' . $hotel->id . ' AND Start_Date > DATE(\'' . date('Y-m-d', $next_date) . '\') ORDER BY Start_Date LIMIT 1');
                    $next_employee = $next_employee->fetch_assoc();
                    /* If there is no such employee, set finish date to some time in the future */
                    if(!$next_employee) {
                        echo "No overlap: There is no next employee\n";
                        $finish_date = time() + rand(86400, 864000);
                    } else {
                        echo "No overlap: Next employee starts at ", $next_employee['Start_Date'], "\n";
                    /* Else set finish date, one day before the next employee's start date */
                        $finish_date = strtotime('-1 day', strtotime($next_employee['Start_Date']));
                    }
                    $irs = self::generateIRS();
                    $data = array_merge([
                        'emp_IRS' => $irs,
                        'SSN' => self::generateSSN(),
                    ], self::generatePerson());
                    $create = Employee::create($data);
                    if(!$create) {
                        die(DB::error() . "\n");
                    }
                    $values = '(' . join(', ', [
                        $irs,
                        $hotel->id,
                        'DATE(\'' . date('Y-m-d', $next_date) . '\')',
                        'DATE(\'' . date('Y-m-d', $finish_date) . '\')',
                        '\'manager\''
                    ]) . ')';
                    $query = DB::query('INSERT INTO Works(' . join(', ', $keys_works) . ') VALUES ' . $values);
                    if(!$query) {
                        die(DB::error() . "\n");
                    }
                    /* In any case, the next date that needs to have a manager work starting then will be one day after finish_date */
                    $next_date = strtotime('+1 day', $finish_date);
                } else {
                    echo "Overlap found: (", $overlap_employee['Start_Date'], ", ", $overlap_employee['Employee_IRS'], ", ", $overlap_employee['Position'], ").\n";
                    /* If one exists, check if start date is before next_date. If so, split their working period into two, with the last being the one in manager position. If not, just change the Position. */
                    if($overlap_employee['Start_Date'] < date('Y-m-d', $next_date)) {
                        echo 'Splitting into (', $overlap_employee['Start_Date'], ', ', date('Y-m-d', strtotime('-1 day', $next_date)), ') and (', date('Y-m-d', $next_date), ', ', $overlap_employee['Finish_Date'], ")\n";
                        $update = DB::query('UPDATE Works SET Finish_Date = DATE(\'' . date('Y-m-d', strtotime('-1 day', $next_date)) . '\') WHERE Employee_IRS = ' . $overlap_employee['Employee_IRS'] . ' AND Start_Date = DATE(\'' . $overlap_employee['Start_Date'] . '\')');
                        if(!$update) {
                            die(DB::error() . "\n");
                        }
                        $values = '(' . join(', ', [
                            $overlap_employee['Employee_IRS'],
                            $hotel->id,
                            'DATE(\'' . date('Y-m-d', $next_date) . '\')',
                            'DATE(\'' . $overlap_employee['Finish_Date'] . '\')',
                            '\'manager\''
                        ]) . ')';
                        $query = DB::query('INSERT INTO Works(' . join(', ', $keys_works) . ') VALUES ' . $values);
                        $next_date = strtotime('+1 day', strtotime($overlap_employee['Finish_Date']));
                    } else {
                        echo 'Changing position for (', $overlap_employee['Start_Date'], ', ', $overlap_employee['Finish_Date'], ") to Manager\n";
                        $update = DB::query('UPDATE Works SET Position = \'manager\' WHERE Employee_IRS = ' . $overlap_employee['Employee_IRS'] . ' AND Start_Date = DATE(\'' . $overlap_employee['Start_Date'] . '\')');
                        if(!$update) {
                            die(DB::error() . "\n");
                        }
                    }
                    $next_date = strtotime('+1 day', strtotime($overlap_employee['Finish_Date']));
                }
                echo "\n";
            }
        }
        date_default_timezone_set($tz);
    }

}