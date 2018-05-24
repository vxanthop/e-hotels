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

    public static function search($data) {
        $sql = 'SELECT Hotel_Room.* FROM Hotel_Room INNER JOIN Hotel ON Hotel_Room.Hotel_ID = Hotel.Hotel_ID INNER JOIN Hotel_group ON Hotel_group.Hotel_group_ID = Hotel.Hotel_group_ID WHERE Hotel.Address_City = "' . $data['city'] . '" AND (Hotel.Number_of_rooms BETWEEN ' . $data['rooms_start'] . ' AND ' . $data['rooms_end'] . ')';
        if($data['capacity'] > 0) {
            $sql .= ' AND Hotel_Room.Capacity = ' . $data['capacity'];
        }
        if($data['stars'] > 0) {
            $sql .= ' AND Hotel.Stars = ' . $data['stars'];
        }
        if(count($data['amenities'])) {
            $sql .= ' AND (SELECT COUNT(amenity) FROM Room_Amenities WHERE Room_ID = Hotel_Room.Room_ID AND Hotel_ID = Hotel_Room.Hotel_ID AND amenity IN (\'' . join('\', \'', $data['amenities']) . '\')) >= ' . count($data['amenities']);
        }
        if(count($data['hotel_groups'])) {
            $sql .= ' AND Hotel_group.Hotel_group_ID IN (' . join(', ', $data['hotel_groups']) . ')';
        }
        $sql .= ' AND (SELECT COUNT(Customer_IRS) FROM Reserves WHERE Room_ID = Hotel_Room.Room_ID AND Hotel_ID = Hotel.Hotel_ID AND Start_Date <= DATE(\'' . $data['end_date'] . '\') AND DATE(\'' . $data['start_date'] . '\') <= IFNULL(Finish_Date, DATE(\'' . $data['start_date'] . '\'))) = 0';
        $query = DB::query($sql);
        return DB::getCollection($query);
    }

    public static function availableInCityNum($city) {
        $query = DB::query('SELECT COUNT(*) AS total FROM Hotel_Room INNER JOIN Hotel ON Hotel.Hotel_ID = Hotel_Room.Hotel_ID WHERE Hotel.Address_City = "' . $city . '" AND (SELECT COUNT(*) FROM Reserves WHERE Room_ID = Hotel_Room.Room_ID AND Hotel_ID = Hotel_Room.Hotel_ID AND CURDATE() BETWEEN Start_Date AND IFNULL(Finish_Date, CURDATE())) = 0');
        $res = $query->fetch_assoc();
        return $res['total'];
    }

    /*
     * @input: The customer that will reserve the room, the start date and the end date of the reservation.
     * @output: None
     * @todo: Integrity check to manually confirm that the customer exists and the room is available for the designated period
     */ 
    public function reserve($customer_irs, $start_date, $finish_date) {
        return DB::query('INSERT INTO Reserves (Customer_IRS, Room_ID, Hotel_ID, Start_Date, Finish_Date) VALUES (' . join(', ', [
            $customer_irs,
            $this->room_id,
            $this->hotel_id,
            'DATE(\'' . $start_date . '\')',
            'DATE(\'' . $finish_date . '\')',
        ]) . ')');
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

    public function hotel_getter() {
        return $this->hotel = Hotel::getOne([
            'hotel_id' => $this->hotel_id
        ]);
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