<?php

namespace controllers;

use \models\HotelGroup as HotelGroup;
use \models\Hotel as Hotel;
use \models\Employee as Employee;
use \models\Customer as Customer;
use \models\DB as DB;

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
        $errors = [];
        $query = HotelGroup::create($create);
        if($query) {
            $group = HotelGroup::getOne([
                'id' => DB::insert_id()
            ]);
            $emails = explode(",", $vars['emails']);
            foreach($emails as $email) {
                $add = $group->addEmail(trim($email));
                if(!$add) {
                    $errors[] = 'Could not add email ' . trim($email) . ' to Hotel Group. Result: ' . $add;
                }
            }
            $phones = explode(",", $vars['phones']);
            foreach($phones as $phone) {
                $add = $group->addPhone(trim($phone));
                if(!$add) {
                    $errors[] = 'Could not add phone ' . trim($phone) . ' to Hotel Group. Result: ' . $add;
                }
            }
        } else {
            $errors[] = 'Could not create Hotel Group. Please try again.';
        }
        return $errors;
    }

    public static function hotelGroupView($id) {
        $data = [
            'group' => HotelGroup::getOne(compact('id')),
            'hotels' => Hotel::ofHotelGroup($id),
        ];
        return $data;
    }

    public static function hotelGroupDelete($id) {
        $delete = HotelGroup::delete(compact('id'));
        $errors = [];
        if(!$delete) {
            $errors[] = 'Could not delete Hotel Group. Please try again.';
        }
        return $errors;
    }

}