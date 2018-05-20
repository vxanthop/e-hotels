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
        $query = DB::query('SELECT * FROM Reserves WHERE Customer_IRS = ' . intval($this->cust_IRS) . ' ORDER BY IFNULL(Finish_Date, DATE(\'9999-12-31\'))');
        while($row = $query->fetch_assoc()) {
            $this->reservations[] = [
                'hotel' => Hotel::getOne([
                    'id' => intval($row['Hotel_ID'])
                ]),
                'room_id' => intval($row['Room_ID']),
                'start_date' => $row['Start_Date'],
                'finish_date' => $row['Finish_Date'],
                'status' => 'Not implemented',
            ];
        }
        return $this->reservations;
    }

}