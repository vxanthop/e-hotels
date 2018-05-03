<?php

namespace models;

class Amenity extends Model {

    public $amenity, $room_id, $employee_id, $hotel_id, $customer_id;

    protected $mapper = [
        'room_id' => ['Room_ID', 'int'],
        'employee_id' => ['Emp_IRS', 'int'],
        'hotel_id' => ['Hotel_ID', 'int'],
        'customer_id' => ['Cust_IRS', 'int']
    ];

    public static function ofRoom($key){
        $query = DB::query('SELECT amenity FROM Hotel_Amenities WHERE
            Room_ID = ' . $key['room_id'] . '
        AND Emp_IRS = ' . $key['employee_id'] . '
        AND Hotel_ID = ' . $key['hotel_id'] . '
        AND Cust_IRS = ' . $key['customer_id']);

        return DB::getCollection($query);
    }

    public static function all(){
        $query = DB::query('SELECT DISTINCT amenity FROM Hotel_Amenities');
    }

}