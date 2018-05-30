<?php

namespace seeders;

use \models\DB as DB;
use \models\Room as Room;
use \models\Customer as Customer;

class RentSeeder extends Seeder {

    public static function run($num) {
        header('Content-type: text/plain');
        // Set default timezone to UTC for proper time calculations
        $tz = date_default_timezone_get();
        date_default_timezone_set('UTC');
        $payment_methods = ['cash', 'credit_card', 'debit_card', 'invoice'];
        $reservations = [];
        $query = DB::query('SELECT * FROM Reserves WHERE Room_ID IS NOT NULL AND (SELECT COUNT(1) FROM Rents WHERE Rents.Room_ID = Reserves.Room_ID AND Rents.Hotel_ID = Reserves.Hotel_ID AND Rents.Start_Date = Reserves.Start_Date) = 0');
        while($row = $query->fetch_assoc()) {
            $reservations[] = $row;
        }
        shuffle($reservations);
        $rent_i = 0;
        foreach($reservations as $reserv) {
            $room = Room::getOne([
                'room_id' => intval($reserv['Room_ID']),
                'hotel_id' => intval($reserv['Hotel_ID'])
            ]);
            if(!$room) continue;
            $query = DB::query('SELECT Employee_IRS FROM Works WHERE Hotel_ID = ' . intval($reserv['Hotel_ID']) . ' AND DATE(\'' . $reserv['Start_Date'] . '\') BETWEEN Start_Date AND Finish_Date');
            $employees = [];
            while($row = $query->fetch_assoc()) {
                $employees[] = intval($row['Employee_IRS']);
            }
            if(!$employees) continue;
            $employee_irs = $employees[rand(0, count($employees) - 1)];
            $payment_method = $payment_methods[rand(0, count($payment_methods) - 1)];
            $checkin = $room->check_in($employee_irs, $reserv['Start_Date'], $payment_method);
            if($checkin) {
                ++$rent_i;
            }
            if($rent_i >= $num) break;
        }
        date_default_timezone_set($tz);
    }

}