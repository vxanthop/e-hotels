<?php

namespace models;

class Room extends Model {

    public $key, $capacity, $view, $expandable, $repairs_need, $price, $amenities;

    protected $mapper = [
        'Capacity' => ['capacity', 'int'],
        'View' => ['view', 'boolean'],
        'Expandable' => 'expandable',
        'Repairs_need' => ['repairs_need', 'boolean'],
        'Price' => ['price', 'float'],
    ];
    
    public static function all() {
        $query = DB::query("SELECT * FROM Hotel_Room");
        $rooms = DB::getCollection($query);

        foreach($rooms as $room) {
            $room->key = [
                'room_id' => $room->Room_ID,
                'hotel_id' => $room->Hotel_ID
            ];

            $room->amenities = Amenity::ofRoom($room->key);
        }

        return $rooms;
    }
}