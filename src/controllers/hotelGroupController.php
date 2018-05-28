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
                'number' => intval($vars['number']),
                'city' => $vars['city'],
                'postal_code' => intval($vars['postal_code']),
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
                        $errors[] = 'Could not add email ' . $email . ' to Hotel Group.';
                    }
                }
            }
            foreach($vars['phones'] as $phone) {
                $phone = intval($phone);
                if($phone) {
                    $add = $group->addPhone($phone);
                    if(!$add) {
                        $errors[] = 'Could not add phone ' . $phone . ' to Hotel Group.';
                    }
                }
            }
        } else {
            $errors[] = 'Could not create Hotel Group. Please try again.';
        }
        return $errors;
    }

    public static function view($id) {
        $group = HotelGroup::getOne(['id' => $id]);
        if(is_null($group)) {
            return NULL;
        }
        $hotels = Hotel::ofHotelGroup($id);
        return compact('group', 'hotels');
    }

    public static function update($id) {
        $data = [
            'group' => HotelGroup::getOne(['id' => $id]),
        ];
        if(is_null($data['group'])) {
            return NULL;
        }
        return $data;
    }

    public static function updateSubmit($vars) {
        $update = [
            'address' => [
                'street' => $vars['street'],
                'number' => intval($vars['number']),
                'city' => $vars['city'],
                'postal_code' => intval($vars['postal_code']),
            ],
            'name' => $vars['name'],
        ];        
        $query = HotelGroup::update([
            'id' => $vars['hotel_group_id']
        ], $update);
        if($query){    
            $group = HotelGroup::getOne([
                'id' => $vars['hotel_group_id']
            ]);
            $group->deleteEmails();
            $group->deletePhones();
            foreach($vars['emails'] as $email) {
                $email = trim($email);
                if(strlen($email)) {
                    $add = $group->addEmail($email);
                    if(!$add) {
                        $errors[] = 'Could not add email ' . $email . ' to Hotel Group.';
                    }
                }
            }
            foreach($vars['phones'] as $phone) {
                $phone = intval($phone);
                if($phone) {
                    $add = $group->addPhone($phone);
                    if(!$add) {
                        $errors[] = 'Could not add phone ' . $phone . ' to Hotel Group.';
                    }
                }
            }
        } else {
            $errors[] = 'Could not update Hotel Group. Please try again.';
        }
        return $errors;
    }

    public static function delete($id) {
        $delete = HotelGroup::delete([
            'id' => $id
        ]);
        $errors = [];
        if(!$delete) {
            $errors[] = 'Could not delete Hotel Group. Please try again.';
        }
        return $errors;
    }

}
