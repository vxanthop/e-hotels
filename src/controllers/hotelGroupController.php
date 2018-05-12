<?php

namespace controllers;

use \models\HotelGroup as HotelGroup;
use \models\Hotel as Hotel;
use \models\DB as DB;

class hotelGroupController {

    public static function create() {

    }

    public static function createSubmit($vars) {
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
            foreach($vars['emails'] as $email) {
                $add = $group->addEmail(trim($email));
                if(!$add) {
                    $errors[] = 'Could not add email ' . trim($email) . ' to Hotel Group. Result: ' . $add;
                }
            }
            foreach($vars['phones'] as $phone) {
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

    public static function view($id) {
        $data = [
            'group' => HotelGroup::getOne(compact('id')),
            'hotels' => Hotel::ofHotelGroup($id),
        ];
        return $data;
    }

    public static function update($id) {
        $data = [
            'group' => HotelGroup::getOne(compact('id')),
        ];
        return $data;
    }

    public static function delete($id) {
        $delete = HotelGroup::delete(compact('id'));
        $errors = [];
        if(!$delete) {
            $errors[] = 'Could not delete Hotel Group. Please try again.';
        }
        return $errors;
    }

}