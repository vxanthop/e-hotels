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
                $email = trim($email);
                if(strlen($email)) {
                    $add = $group->addEmail($email);
                    if(!$add) {
                        $errors[] = 'Could not add email ' . $email . ' to Hotel Group. Result: ' . $add;
                    }
                }
            }
            foreach($vars['phones'] as $phone) {
                $phone = trim($phone);
                if(strlen($phone)) {
                    $add = $group->addPhone($phone);
                    if(!$add) {
                        $errors[] = 'Could not add phone ' . $phone . ' to Hotel Group. Result: ' . $add;
                    }
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

    public static function updateSubmit($vars) {
        $update = [
            'address' => [
                'street' => $vars['street'],
                'number' => $vars['number'],
                'city' => $vars['city'],
                'postal_code' => $vars['postal_code'],
            ],
            'name' => $vars['name'],
        ];        
        $query = HotelGroup::update(['id' => $vars['hotel_group_id']], $update);
        if($query){    
            $group = HotelGroup::GetOne([
                'id' => $vars['hotel_group_id']
            ]);
            $group->deleteEmails();
            $group->deletePhones();
            foreach($vars['emails'] as $email) {
                $email = trim($email);
                if(strlen($email)) {
                    $add = $group->addEmail($email);
                    if(!$add) {
                        $errors[] = 'Could not add email ' . $email . ' to Hotel Group. Result: ' . $add;
                    }
                }
            }
            foreach($vars['phones'] as $phone) {
                $phone = trim($phone);
                if(strlen($phone)) {
                    $add = $group->addPhone($phone);
                    if(!$add) {
                        $errors[] = 'Could not add phone ' . $phone . ' to Hotel Group. Result: ' . $add;
                    }
                }
            }
        } else {
            $errors[] = 'Could not update Hotel Group. Please try again.';
        }
        return $errors;
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
