<?php

namespace controllers;

use \models\HotelGroup as HotelGroup;
use \models\Hotel as Hotel;
use \models\Room as Room;
use \models\DB as DB;

class roomController {

    public static function create($hotel_id) {
        $hotel = Hotel::getOne([
            'id' => intval($hotel_id)
        ]);
        $group = HotelGroup::getOne(['id' => $hotel->hotel_group_id]);
        return compact('hotel', 'group');
    }

    public static function createSubmit($vars) {
        $create = [
            'hotel_id' => intval($vars['hotel_id']),
            'capacity' => intval($vars['capacity']),
            'view' => isset($vars['view']) && $vars['view'] == 'yes',
            'expandable' => $vars['expandable'],
            'repairs_need' => isset($vars['repairs_need']) && $vars['repairs_need'] == 'yes',
            'price' => floatval($vars['price']),
        ];
        $errors = [];
        $query = Room::create($create);
        if(!$query) {
            $errors[] = 'Could not create Room. Please try again.';
        }
        return $errors;
    }

    public static function update($room_id) {
        $room = Room::getOne([
            'room_id' => intval($room_id)
        ]);
        $hotel = Hotel::getOne(['id' => $room->hotel_id]);
        $group = HotelGroup::getOne(['id' => $hotel->hotel_group_id]);
        return compact('room', 'hotel', 'group');
    }

    public static function updateSubmit($vars) {
        $update = [
            'capacity' => intval($vars['capacity']),
            'view' => isset($vars['view']) && $vars['view'] == 'yes',
            'expandable' => $vars['expandable'],
            'repairs_need' => isset($vars['repairs_need']) && $vars['repairs_need'] == 'yes',
            'price' => floatval($vars['price']),
        ];

        $errors = [];
        $room = Room::getOne([
            'room_id' => intval($vars['room_id'])
        ]);
        $query = Room::update([
            'room_id' => intval($vars['room_id'])
        ], $update);
        if(!$query){    
            $errors[] = 'Could not update Room. Please try again.';
        }
        return $errors;
    }

    public static function delete($id) {
        $delete = Room::delete(['room_id' => intval($id)]);
        $errors = [];
        if(!$delete) {
            $errors[] = 'Could not delete Room. Please try again.';
        }
        return $errors;
    }

}