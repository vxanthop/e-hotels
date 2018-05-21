<?php

namespace controllers;

use \models\HotelGroup as HotelGroup;
use \models\Hotel as Hotel;
use \models\Room as Room;
use \models\Customer as Customer;
use \models\Amenity as Amenity;
use \models\City as City;

class reservationController {

    public static function prepare($vars) {
        /* CHECKS IF ROOM IS AVAILABLE ETC. */
        $room = Room::getOne([
            'room_id' => intval($vars['room_id']),
            'hotel_id' => intval($vars['hotel_id'])
        ]);
        $hotel = Hotel::getOne([
            'hotel_id' => intval($vars['hotel_id'])
        ]);
        if(!isset($vars['irs'])) {
            $first_name = $_GET['first_name'] ?? '';
            $last_name = $_GET['last_name'] ?? '';
            $query = [];
            $customers = [];
            if(strlen($first_name) && strlen($last_name)) {
                $query = compact('first_name', 'last_name');
                $customers = Customer::getMany($query);
            }
            return compact('room', 'hotel', 'query', 'customers');
        } else {
            $customer = Customer::getOne([
                'cust_IRS' => intval($vars['irs'])
            ]);
            return compact('room', 'hotel', 'customer');
        }
    }

    public static function createSubmit($vars) {
        /* TODO: IMPLEMENT */
        $errors = [];
        return $errors;
    }
    
}