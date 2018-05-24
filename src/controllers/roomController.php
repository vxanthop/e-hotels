<?php

namespace controllers;

use \models\HotelGroup as HotelGroup;
use \models\Hotel as Hotel;
use \models\Room as Room;
use \models\DB as DB;

class roomController {

    public static function create($hotel_id) {
        $hotel = Hotel::getOne([
            'id' => $hotel_id
        ]);
        $group = HotelGroup::getOne(['id' => $hotel->hotel_group_id]);
        return compact('hotel', 'group');
    }

    public static function createSubmit($vars) {
        $create = [
            'hotel_id' => $vars['hotel_id'],
            'capacity' => intval($vars['capacity']),
            'view' => isset($vars['view']) && $vars['view'] == 'yes',
            'expandable' => $vars['expandable'],
            'repairs_need' => isset($vars['repairs_need']) && $vars['repairs_need'] == 'yes',
            'price' => floatval($vars['price']),
        ];
        $errors = [];
        $query = Room::create($create);
        if($query) {
            $room = Room::getOne([
                'id' => DB::insert_id()
            ]);
            foreach($vars['amenities'] as $amenity) {
                $amenity = trim($amenity);
                if(strlen($amenity)) {
                    $add = $room->addAmenity($amenity);
                    if(!$add) {
                        $errors[] = 'Could not add Amenity "' . $amenity . '" to Room.';
                    }
                }
            }
        } else {
            $errors[] = 'Could not create Room. Please try again.';
        }
        return $errors;
    }

    public static function update($room_id) {
        $room = Room::getOne([
            'room_id' => $room_id
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
        $query = Room::update([
            'room_id' => $vars['room_id']
        ], $update);
        if($query) {
            $room = Room::getOne([
                'room_id' => $vars['room_id']
            ]);
            $room->deleteAmenities();
            foreach($vars['amenities'] as $amenity) {
                $amenity = trim($amenity);
                if(strlen($amenity)) {
                    $add = $room->addAmenity($amenity);
                    if(!$add) {
                        $errors[] = 'Could not add Amenity "' . $amenity . '" to Room.';
                    }
                }
            }
        } else { 
            $errors[] = 'Could not update Room. Please try again.';
        }
        return $errors;
    }

    public static function delete($id) {
        $delete = Room::delete(['room_id' => $id]);
        $errors = [];
        if(!$delete) {
            $errors[] = 'Could not delete Room. Please try again.';
        }
        return $errors;
    }

    public static function view($hotel_id, $room_id) {
        $room = Room::getOne([
            'hotel_id' => $hotel_id,
            'room_id' => $room_id
        ]);
        $hotel = Hotel::getOne([
            'id' => $hotel_id
        ]);
        $group = HotelGroup::getOne([
            'id' => $hotel->hotel_group_id
        ]);
        return compact('room', 'hotel', 'group');
    }

}