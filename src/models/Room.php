<?php

namespace models;

class Room extends Model {

    public $key, $capacity, $view, $expandable, $repairs_need, $price, $amenities;
    
    public static function all(){
        $query = DB::query("SELECT * FROM Hotel_room");
        $rooms = DB::getCollection($query);

        foreach($rooms as $room){
            $room->key = [
                'room_id' => $room->Room_ID,
                'employee_id' => $room->Emp_IRS,
                'hotel_id' => $room->Hotel_ID,
                'customer_id' => $room->Cust_IRS
            ];

            $room->amenities = Amenity::ofRoom($room->key);
        }
    }
}