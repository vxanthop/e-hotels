<?php

namespace controllers;

use \models\HotelGroup as HotelGroup;
use \models\Hotel as Hotel;
use \models\Room as Room;
use \models\DB as DB;

class hotelController {

    public static function create($hotel_group_id) {
        $data = [
            'group' => HotelGroup::getOne(['id' => $hotel_group_id]),
        ];
        return $data;
    }

    public static function createSubmit($vars) {
        $create = [
            'hotel_group_id' => $vars['hotel_group_id'],
            'address' => [
                'street' => $vars['street'],
                'number' => $vars['number'],
                'city' => $vars['city'],
                'postal_code' => $vars['postal_code'],
            ],
            'name' => $vars['name'],
            'stars' => $vars['stars'],
        ];
        $errors = [];
        $query = Hotel::create($create);
        if($query) {
            $hotel = Hotel::getOne([
                'id' => DB::insert_id()
            ]);
            foreach($vars['emails'] as $email) {
                $add = $hotel->addEmail(trim($email));
                if(!$add) {
                    $errors[] = 'Could not add email ' . trim($email) . ' to Hotel Group. Result: ' . $add;
                }
            }
            foreach($vars['phones'] as $phone) {
                $add = $hotel->addPhone(trim($phone));
                if(!$add) {
                    $errors[] = 'Could not add phone ' . trim($phone) . ' to Hotel Group. Result: ' . $add;
                }
            }
        } else {
            $errors[] = 'Could not create Hotel. Please try again.';
        }
        return $errors;
    }

    public static function view($id) {
        $hotel = Hotel::getOne(['id' => $id]);
        $group = HotelGroup::getOne(['id' => $hotel->hotel_group_id]);
        $rooms = Room::ofHotel($id);
        return compact('hotel', 'group', 'rooms');
    }

    public static function update($id) {
        $hotel = Hotel::getOne(compact('id'));
        $group = HotelGroup::getOne(['id' => $hotel->hotel_group_id]);
        return compact('hotel', 'group');
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
            'stars' => $vars['stars'],
        ];
        $errors = [];
        $hotel = Hotel::getOne([
            'id' => $vars['hotel_id']
        ]);
        $group_id = $hotel->hotel_group_id;
        $query = Hotel::update(['id' => $vars['hotel_id']], $update);
        if($query){    
            $hotel = Hotel::getOne([
                'id' => $vars['hotel_id']
            ]);
            $hotel->deleteEmails();
            $hotel->deletePhones();
            foreach($vars['emails'] as $email) {
                $email = trim($email);
                if(strlen($email)) {
                    $add = $hotel->addEmail($email);
                    if(!$add) {
                        $errors[] = 'Could not add email ' . $email . ' to Hotel. Result: ' . $add;
                    }
                }
            }
            foreach($vars['phones'] as $phone) {
                $phone = trim($phone);
                if(strlen($phone)) {
                    $add = $hotel->addPhone($phone);
                    if(!$add) {
                        $errors[] = 'Could not add phone ' . $phone . ' to Hotel. Result: ' . $add;
                    }
                }
            }
        } else {
            $errors[] = 'Could not update Hotel. Please try again.';
        }
        return $errors;
    }

    public static function delete($id) {
        $delete = Hotel::delete(compact('id'));
        $errors = [];
        if(!$delete) {
            $errors[] = 'Could not delete Hotel. Please try again.';
        }
        return $errors;
    }

}