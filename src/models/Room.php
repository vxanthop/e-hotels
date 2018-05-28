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
        $search_sql = 'SELECT Hotel_Room.*, Hotel.Address_City FROM Hotel_Room INNER JOIN Hotel ON Hotel_Room.Hotel_ID = Hotel.Hotel_ID INNER JOIN Hotel_group ON Hotel_group.Hotel_group_ID = Hotel.Hotel_group_ID WHERE (Hotel_Room.Price BETWEEN ' . $data['price_min'] . ' AND ' . $data['price_max'] . ')';
        if($data['city']) {
            $search_sql .= ' AND Hotel.Address_City = "' . $data['city'] . '"';
        }
        if($data['capacity'] > 0) {
            $search_sql .= ' AND Hotel_Room.Capacity = ' . $data['capacity'];
        }
        if($data['stars'] > 0) {
            $search_sql .= ' AND Hotel.Stars = ' . $data['stars'];
        }
        if(count($data['amenities'])) {
            $search_sql .= ' AND (SELECT COUNT(amenity) FROM Room_Amenities WHERE Room_ID = Hotel_Room.Room_ID AND Hotel_ID = Hotel_Room.Hotel_ID AND amenity IN (\'' . join('\', \'', $data['amenities']) . '\')) >= ' . count($data['amenities']);
        }
        if(count($data['hotel_groups'])) {
            $search_sql .= ' AND Hotel_group.Hotel_group_ID IN (' . join(', ', $data['hotel_groups']) . ')';
        }
        $search_sql .= ' AND (SELECT COUNT(Customer_IRS) FROM Reserves WHERE Room_ID = Hotel_Room.Room_ID AND Hotel_ID = Hotel.Hotel_ID AND Start_Date <= DATE(\'' . $data['end_date'] . '\') AND DATE(\'' . $data['start_date'] . '\') <= IFNULL(Finish_Date, DATE(\'' . $data['start_date'] . '\'))) = 0';
        $sql = 'WITH search_res AS (' . $search_sql . ') SELECT search_res.*, total_in_city FROM search_res LEFT JOIN (SELECT Address_City, COUNT(1) AS total_in_city FROM search_res GROUP BY Address_City) AS n ON n.Address_City = search_res.Address_City WHERE total_in_city >= ' . $data['rooms_num'];
        $query = DB::query($sql);
        return DB::getCollection($query);
    }

    /*
     * @todo: Include check for $data['rooms_num']
     */
    public static function searchPerCity($data) {
        $sql = 'SELECT COUNT(1) AS availableRoomsNum, Hotel.Address_City AS city FROM Hotel_Room INNER JOIN Hotel ON Hotel_Room.Hotel_ID = Hotel.Hotel_ID INNER JOIN Hotel_group ON Hotel_group.Hotel_group_ID = Hotel.Hotel_group_ID WHERE (Hotel_Room.Price BETWEEN ' . $data['price_min'] . ' AND ' . $data['price_max'] . ')';
        if($data['city']) {
            $sql .=  ' AND Hotel.Address_City = "' . $data['city'] . '"';
        }
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
        $sql .= ' GROUP BY Hotel.Address_City HAVING COUNT(1) >= ' . $data['rooms_num'];
        $query = DB::query($sql);
        $result = [];
        while ($row = $query->fetch_assoc()) {
            $result[] = $row;
        }
        return $result;
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
     * @input: Start date of the reservation (remember that a reservation is uniquely identified by the room and the start date)
     * @output: An associative array with keys customer, start_date, finish_date, status, payment_method, payment_amount and rent_id that represents the reservation
     * @todo: Fix status
     */
    public function getReservation($start_date) {
        $query = DB::query('SELECT Reserves.*, Rents.Rent_ID, Rents.Employee_IRS, Payment_Transaction.Payment_Method, Payment_Transaction.Payment_Amount FROM Reserves LEFT JOIN Rents ON Reserves.Room_ID = Rents.Room_ID AND Reserves.Hotel_ID = Rents.Hotel_ID AND Reserves.Start_Date = Rents.Start_Date LEFT JOIN Payment_Transaction ON Rents.Rent_ID = Payment_Transaction.Rent_ID WHERE Reserves.Room_ID = ' . $this->room_id . ' AND Reserves.Hotel_ID = ' . $this->hotel_id . ' AND Reserves.Start_Date = DATE(\'' . $start_date . '\') ORDER BY IFNULL(Reserves.Finish_Date, DATE(\'9999-12-31\'))');
        $row = $query->fetch_assoc();
        if(is_null($row)) {
            return NULL;
        }
        $reservation = [
            'customer' => Customer::getOne([
                'cust_IRS' => intval($row['Customer_IRS'])
            ]),
            'employee' => is_null($row['Rent_ID']) ? NULL : Employee::getOne([
                'emp_IRS' => intval($row['Employee_IRS'])
            ]),
            'start_date' => $row['Start_Date'],
            'finish_date' => $row['Finish_Date'],
            'rent_id' => intval($row['Rent_ID']),
            'payment_amount' => floatval($row['Payment_Amount']),
            'payment_method' => $row['Payment_Method'],
        ];
        $reservation['status'] = is_null($row['Rent_ID']) ? 'Reserved' : 'Rented';
        return $reservation;
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

    public function status_getter() {
        $query = DB::query('SELECT COUNT(*) AS cnt FROM Reserves WHERE Room_ID = ' . $this->room_id . ' AND Hotel_ID = ' . $this->hotel_id . ' AND CURDATE() BETWEEN Start_Date AND IFNULL(Finish_Date, CURDATE())');
        $res = $query->fetch_assoc();
        if($res['cnt'] == 0) {
            return $this->status = 'Available';
        } else {
            return $this->status = 'Reserved';
        }
    }
    
    public function reservations_getter() {
        $this->reservations = [];
        $query = DB::query('SELECT Reserves.*, Rents.Rent_ID FROM Reserves LEFT JOIN Rents ON Rents.Room_ID = Reserves.Room_ID AND Rents.Hotel_ID = Reserves.Hotel_ID AND Rents.Start_Date = Reserves.Start_Date WHERE Reserves.Room_ID = ' . $this->room_id . ' AND Reserves.Hotel_ID = ' . $this->hotel_id . ' ORDER BY IFNULL(Reserves.Finish_Date, DATE(\'9999-12-31\')) DESC');
        while($row = $query->fetch_assoc()) {
            $this->reservations[] = [
                'customer' => Customer::getOne([
                    'cust_IRS' => intval($row['Customer_IRS'])
                ]),
                'start_date' => $row['Start_Date'],
                'finish_date' => $row['Finish_Date'],
                'status' => is_null($row['Rent_ID']) ? 'Reserved' : 'Rented',
            ];
        }
        return $this->reservations;
    }

}