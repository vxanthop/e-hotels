<?php

namespace seeders;

use \models\DB as DB;
use \models\Room as Room;
use \models\Customer as Customer;

class ReservationSeeder extends Seeder {

    public static function run($num) {
        header('Content-type: text/plain');
        // Set default timezone to UTC for proper time calculations
        $tz = date_default_timezone_get();
        date_default_timezone_set('UTC');
        $rooms = Room::all();
        if(isset($_GET['withMax'])) {
            $rooms = array_values(array_filter($rooms, function ($room) {
                return count($room->reservations) <= intval($_GET['withMax']);
            }));
        }
        shuffle($rooms);
        $customers = Customer::all();
        $room_i = 0;
        $reserv_i = 0;
        while($room_i < count($rooms)) {
            if(!isset($_GET['now'])) {
                /* From 2005-01-01 until now */
                $start = rand(1104537600, time());
            } else {
                /* From before a month until now */
                $start = rand(time() - 2592000, time());
            }
            $rem_reservations = rand(0, ceil(($num - $reserv_i - 1) / (count($rooms) - $room_i)));
            while(intdiv($start, 86400) < intdiv(time(), 86400) && $rem_reservations > 0 && $reserv_i < $num) {
                $customer = $customers[rand(0, count($customers) - 1)];
                if(!isset($_GET['now'])) {
                    /* Random duration from 0 to 2 months */
                    $duration = rand(1, 5184000);
                } else {
                    /* Random duration so that today is surely included */
                    $duration = rand(time() - $start, 5184000);
                }
                $query = $rooms[$room_i]->reserve($customer->cust_IRS, date('Y-m-d', $start), date('Y-m-d', $start + $duration));
                if($query) {
                    ++$reserv_i;
                    --$rem_reservations;
                } else {
                    echo DB::error(), "\n";
                }
                /* No reservation period for room between 0 and 1 year */
                $skip = rand(0, 31536000);
                /* Start from next day + skip */
                $start = (intdiv($start + $duration, 86400) + 1) * 86400 + $skip;
            }
            ++$room_i;
        }
        date_default_timezone_set($tz);
    }

}