<?php

namespace controllers;

use \models\HotelGroup as HotelGroup;
use \models\Hotel as Hotel;
use \models\Room as Room;
use \models\DB as DB;

class roomController {

    public static function create($hotel_id) {
        $hotel = Hotel::getOne(['id' => $hotel_id]);
        $group = HotelGroup::getOne(['id' => $hotel->hotel_group_id]);
        return compact('hotel', 'group');
    }

    public static function createSubmit($vars) {
        $create = [
            'hotel_id' => $vars['hotel_id'],
            'capacity' => $vars['capacity'],
            'view' => $vars['view'],
            'expandable' => $vars['expandable'],
            'repairs_need' => $vars['repairs_need'],
            'price' => $vars['price'],
        ];
        $errors = [];
        $query = Room::create($create);
        if(!$query) {
            $errors[] = 'Could not create Room. Please try again.';
        }
        return $errors;
    }

    public static function update($room_id) {
        $room = Room::getOne(['room_id' => $room_id]);
        $hotel = Hotel::getOne(['id' => $room->hotel_id]);
        $group = HotelGroup::getOne(['id' => $hotel->hotel_group_id]);
        return compact('room', 'hotel', 'group');
    }

    public static function updateSubmit($vars) {
        $update = [
            'capacity' => $vars['capacity'],
            'view' => $vars['view'],
            'expandable' => $vars['expandable'],
            'repairs_need' => $vars['repairs_need'],
            'price' => $vars['price'],
        ];

        $errors = [];
        $room = Room::getOne(['room_id' => $vars['room_id']]);
        $hotel_id = $room->hotel_id;
        $query = Room::update(['room_id' => $vars['room_id']], $update);
        if(!$query){    
            $errors[] = 'Could not update Room. Please try again.';
        }
        return compact('errors', 'hotel_id');
    }

    public static function delete($id) {
        $delete = Room::delete(compact('id'));
        $errors = [];
        if(!$delete) {
            $errors[] = 'Could not delete Room. Please try again.';
        }
        return $errors;
    }

}