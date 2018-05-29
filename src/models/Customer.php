<?php

namespace models;

class Customer extends Model {

    public $cust_IRS, $SSN, $first_name, $last_name, $first_registration, $address;
    
    protected static $table = 'Customer';
    protected static $mapper = [
        'Customer_IRS' => 'cust_IRS',
        'Social_Security_Number' => 'SSN',
        'First_Name' => 'first_name',
        'Last_Name' => 'last_name',
        'First_Registration' => ['first_registration', 'date'],
        'Address_Street' => 'address[street]',
        'Address_Number' => ['address[number]', 'int'],
        'Address_City' => 'address[city]',
        'Address_Postal_Code' => ['address[postal_code]', 'int'],
    ];

    public static function all() {
        $query = DB::query('SELECT * FROM Customer ORDER BY First_Registration DESC');
        return DB::getCollection($query);
    }

    public function fullname_getter() {
        return $this->fullname = $this->first_name . " " . $this->last_name;
    }
    
    public function reservations_getter() {
        $this->reservations = [];
        $query = DB::query('SELECT Reserves.*, Rents.Rent_ID, Payment_Transaction.Payment_Method, Payment_Transaction.Payment_Amount FROM Reserves LEFT JOIN Rents ON Rents.Hotel_ID = Reserves.Hotel_ID AND Rents.Room_ID = Reserves.Room_ID AND Rents.Start_Date = Reserves.Start_Date LEFT JOIN Payment_Transaction ON Payment_Transaction.Rent_ID = Rents.Rent_ID WHERE Reserves.Customer_IRS = ' . intval($this->cust_IRS) . ' ORDER BY Reserves.Start_Date DESC');
        while($row = $query->fetch_assoc()) {
            $this->reservations[] = [
                'hotel' => Hotel::getOne([
                    'id' => intval($row['Hotel_ID'])
                ]),
                'room_id' => intval($row['Room_ID']),
                'start_date' => $row['Start_Date'],
                'finish_date' => $row['Finish_Date'],
                'date_diff' => (strtotime($row['Finish_Date']) - strtotime($row['Start_Date'])) / 86400 + 1,
                'status' => is_null($row['Rent_ID']) ? 'Reserved' : 'Rented',
                'rent_id' => intval($row['Rent_ID']),
                'payment_amount' => floatval($row['Payment_Amount']),
                'payment_method' => $row['Payment_Method'],
            ];
        }
        return $this->reservations;
    }

}