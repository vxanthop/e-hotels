<?php

namespace controllers;

use \models\HotelGroup as HotelGroup;
use \models\Hotel as Hotel;
use \models\Room as Room;
use \models\Customer as Customer;
use \models\Employee as Employee;
use \models\Amenity as Amenity;
use \models\City as City;

class reservationController {

    public static function prepare($vars) {
        $room = Room::getOne([
            'room_id' => intval($vars['room_id']),
            'hotel_id' => intval($vars['hotel_id'])
        ]);
        if(is_null($room)) {
            return NULL;
        }
        $hotel = Hotel::getOne([
            'id' => intval($vars['hotel_id'])
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
            $date_diff = (strtotime($_GET['end_date']) - strtotime($_GET['start_date'])) / 86400 + 1;
            if(is_null($customer)) {
                return NULL;
            }
            return compact('room', 'hotel', 'customer', 'date_diff');
        }
    }

    public static function createSubmit($vars) {
        $errors = [];

        if(isset($vars['room_id'])) {
            $room = Room::getOne([
                'room_id' => intval($vars['room_id'])
            ]); 
            $assign = $room->reserve(
                intval($vars['irs']),
                $vars['start_date'],
                $vars['end_date']
            );
            if(!$assign) {
                $errors[] = 'Could not reserve to Room. Please try again.';
            }
        } else {
            $errors[] = 'Could not create Room. Please try again.';
        }
        return $errors;
    }

    public static function checkIn($vars) {
        $room = Room::getOne([
            'room_id' => intval($vars['room_id']),
            'hotel_id' => intval($vars['hotel_id'])
        ]);
        if(is_null($room)) {
            return NULL;
        }
        $hotel = Hotel::getOne([
            'id' => intval($vars['hotel_id'])
        ]);
        $group = HotelGroup::getOne([
            'id' => $hotel->hotel_group_id
        ]);
        $reservation = $room->getReservation($vars['start_date']);
        if(is_null($reservation)) {
            return NULL;
        }
        if(!isset($vars['employee_irs'])) {
            $first_name = $_GET['first_name'] ?? '';
            $last_name = $_GET['last_name'] ?? '';
            $query = [];
            if(strlen($first_name) && strlen($last_name)) {
                $query = compact('first_name', 'last_name');
                $employees = Employee::searchInHotel($query, $hotel->id);
            } else {
                $employees = Employee::ofHotel($hotel->id);  
            }
            return compact('room', 'hotel', 'group', 'reservation', 'query', 'employees');
        } else {
            $employee = Employee::getOne([
                'emp_IRS' => intval($vars['employee_irs'])
            ]);
            if(is_null($employee)) {
                return NULL;
            }
            return compact('room', 'hotel', 'group', 'reservation', 'employee');
        }
    }
    
    public static function checkInSubmit($vars) {
        $errors = [];

        if(isset($vars['room_id'])) {
            $room = Room::getOne([
                'room_id' => intval($vars['room_id'])
            ]); 
            $assign = $room->check_in(
                $vars['employee_irs'],
                $vars['start_date'],
                intval($vars['transaction_amount']),
                $vars['transaction_method']
            );
            if(!$assign) {
                $errors[] = 'Could not complete the payment transaction for the Room. Please try again.';
            }
        } else {
            $errors[] = 'Could not check-in to Room. Please try again.';
        }

        return $errors;
    }

    public static function view($vars) {
        $room = Room::getOne([
            'room_id' => intval($vars['room_id']),
            'hotel_id' => intval($vars['hotel_id'])
        ]);
        if(is_null($room)) {
            return NULL;
        }
        $hotel = Hotel::getOne([
            'id' => intval($vars['hotel_id'])
        ]);
        $group = HotelGroup::getOne([
            'id' => $hotel->hotel_group_id
        ]);
        $reservation = $room->getReservation($vars['start_date']);
        if(is_null($reservation)) {
            return NULL;
        }
        return compact('room', 'hotel', 'group', 'reservation');
    }
    
}