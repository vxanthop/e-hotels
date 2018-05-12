<?php

namespace models;

class Room extends Model {

    public $room_id, $hotel_id, $capacity, $view, $expandable, $repairs_need, $price, $img_src;

    protected static $table = 'Hotel_Room';
    protected static $mapper = [
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

    /*
     * @input: The customer that will reserve the room, the start date and the end date of the reservation.
     * @output: None
     * @todo: Integrity check to manually confirm that the customer exists and the room is available for the designated period
     */ 
    public function reserve($customer_irs, $start_date, $finish_date) {
        DB::query('INSERT INTO Reserves (Customer_IRS, Room_ID, Hotel_ID, Start_Date, Finish_Date) VALUES (' . join(", ", [
            $customer_irs,
            $this->room_id,
            $this->hotel_id,
            $start_date,
            $finish_date,
        ]));
    }

    /*
     * @input: None
     * @output: None
     * @todo: Implementation
     * Marks the room as rented.
     */
    public function check_in() {

    }

    public function amenities_getter() {
        return $this->amenities = Amenity::ofRoom($room_id, $hotel_id);
    }

    /*
     * @input: None
     * @output: A Customer object representing the customer that is currently renting this room. If none is found, returns NULL.
     */ 
    public function current_customer_getter() {
        $query = DB::query('SELECT Customer_IRS FROM Reserves WHERE Room_ID = ' . $this->room_id . ' AND Hotel_ID = ' . $this->hotel_id . ' AND CURDATE() BETWEEN Start_Date AND IFNULL(End_Date, CURDATE())');
        $irs = [];
        while($row = $query->fetch_assoc()) {
            $irs[] = intval($row['Customer_IRS']);
        }
        if(count($irs) == 1) {
            return Customer::getOne(['id' => $irs[0]]);
        } else {
            return NULL;
        }
    }

}