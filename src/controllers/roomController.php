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

    public static function update($room_id) {
        $room = Room::getOne(['room_id' => $room_id]);
        $hotel = Hotel::getOne(['id' => $room->hotel_id]);
        $group = HotelGroup::getOne(['id' => $hotel->hotel_group_id]);
        return compact('room', 'hotel', 'group');
    }

}