<?php

namespace controllers;

use \models\HotelGroup as HotelGroup;
use \models\Hotel as Hotel;
use \models\Employee as Employee;
use \models\Customer as Customer;

class adminController {

    public static function index() {
        $data = [
            'hotel_groups' => HotelGroup::all(),
            'employees' => [],
            'customers' => [],
        ];
        return $data;
    }

    public static function hotelGroupCreateSubmit($vars) {
        $create = [
            'address' => [
                'street' => $vars['street'],
                'number' => $vars['number'],
                'city' => $vars['city'],
                'postal_code' => $vars['postal_code'],
            ],
            'name' => $vars['name'],
        ];
        return HotelGroup::create($create);
    }

    public static function hotelGroupView($id) {
        $data = [
            'group' => HotelGroup::getOne(compact('id')),
            'hotels' => Hotel::ofHotelGroup($id),
        ];
        return $data;
    }

}