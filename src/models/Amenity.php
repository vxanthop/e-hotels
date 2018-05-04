<?php

namespace models;

class Amenity extends Model {

    public $amenity, $room_id, $hotel_id;

    protected $mapper = [
        'Room_ID' => ['room_id', 'int'],
        'Hotel_ID' => ['hotel_id', 'int'],
    ];

    /*
        @input: A key array that contains the primary keys of a Room entry
        @output: An array of Amenity objects that represent the amenities available in the specified Room
    */
    public static function ofRoom($key) {
        $query = DB::query('SELECT amenity FROM Hotel_Amenities WHERE
            Room_ID = ' . $key['room_id'] . '
        AND Hotel_ID = ' . $key['hotel_id']);

        return DB::getCollection($query);
    }

    /*
        @input: None
        @output: An array of strings representing all the various amenities available among all hotels and rooms
    */
    public static function all(){
        $query = DB::query('SELECT DISTINCT amenity FROM Hotel_Amenities');
        $amenities = [];
        /*  For each result in the query, fetch_assoc() will return an associative array
            like ['amenity' => value]
        */
        while($row = $query->fetch_assoc()) {
            $amenities[] = $row['amenity'];
        }
        return $amenities;
    }

}