<?php

namespace controllers;

use \models\Customer as Customer;
use \models\Hotel as Hotel;
use \models\Room as Room;
use \models\DB as DB;

class customerController {

    public static function register($irs = NULL) {
        return [];
    }

    public static function registerSubmit($vars) {
        $create = [
            'cust_IRS' => intval($vars['irs']),
            'SSN' => intval($vars['ssn']),
            'first_name' => $vars['first'],
            'last_name' => $vars['last'],
            'address' => [
                'street' => $vars['street'],
                'number' => intval($vars['number']),
                'city' => $vars['city'],
                'postal_code' => intval($vars['postal_code']),
            ],
        ];
        $query = Customer::create($create);
        $errors = [];
        if(!$query) {
            $errors[] = 'Could not create Employee. Please try again.';
        }
        return $errors;
    }

    public static function update($irs) {
        $cust = Customer::getOne(['cust_IRS' => $irs]);
        return ['customer' => $cust];
    }

    public static function updateSubmit($vars) {
        $update = [
            'SSN' => intval($vars['ssn']),
            'first_name' => $vars['first'],
            'last_name' => $vars['last'],
            'address' => [
                'street' => $vars['street'],
                'number' => intval($vars['number']),
                'city' => $vars['city'],
                'postal_code' => intval($vars['postal_code']),
            ],
        ];
        $errors = [];
        $query = Customer::update([
            'cust_IRS' => intval($vars['irs'])
        ], $update);
        if(!$query) { 
            $errors[] = 'Could not update Employee. Please try again.';
        }
        return $errors;
    }

    public static function view($irs) {
        $customer = Customer::getOne([
            'cust_IRS' => $irs
        ]);
        return ['customer' => $customer];
    }
}