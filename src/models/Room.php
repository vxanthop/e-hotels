<?php

namespace models;

class Room extends Model {

    public $room_id, $hotel_id, $capacity, $view, $expandable, $repairs_need, $price;

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
        $query = DB::query('SELECT * FROM Hotel_Room');
        return DB::getCollection($query);
    }

    public static function ofHotel($hotel_id) {
        $query = DB::query('SELECT * FROM Hotel_Room WHERE Hotel_ID = ' . $hotel_id);
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
        return $this->amenities = Amenity::ofRoom($this->room_id, $this->hotel_id);
    }

    public function addAmenity($amenity) {
        return DB::query('INSERT INTO Room_Amenities(Room_ID, Hotel_ID, amenity) VALUES(' . join(', ', [
            $this->room_id,
            $this->hotel_id,
            '"' . $amenity . '"'
        ]) . ')');
    }

    public function deleteAmenities() {
        return DB::query('DELETE FROM Room_Amenities WHERE Room_ID = ' . $this->room_id . ' AND Hotel_ID = ' . $this->hotel_id);
    }

    public function expandable_description_getter() {
        $arr = [
            '' => 'No',
            'connecting_room' => 'Yes (connecting rooms)',
            'more_beds' => 'Yes (more beds)'
        ];
        return $this->expandable_description = $arr[$this->expandable];
    }

}