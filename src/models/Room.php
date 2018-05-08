<?php

namespace models;

class Room extends Model {

    public $room_id, $hotel_id, $capacity, $view, $expandable, $repairs_need, $price;

    protected $mapper = [
        'Room_ID' => ['room_id', 'int'],
        'Hotel_ID' => ['hotel_id', 'int'],
        'Capacity' => ['capacity', 'int'],
        'View' => ['view', 'boolean'],
        'Expandable' => 'expandable',
        'Repairs_need' => ['repairs_need', 'boolean'],
        'Price' => ['price', 'float'],
    ];
    
    public static function all() {
        $query = DB::query("SELECT * FROM Hotel_Room");
        return DB::getCollection($query);
    }

    public function amenities_getter() {
        return $this->amenities = Amenity::ofRoom($room_id, $hotel_id);
    }

}