<?php

namespace models;

class Hotel extends Model {

    public $id, $name, $address, $hotel_group_id, $stars, $number_of_rooms;

    protected static $table = 'Hotel';
    protected static $mapper = [
        'Hotel_ID' => ['id', 'int'],
        'Hotel_Name' => 'name',
        'Stars' => ['stars', 'int'],
        'Number_of_rooms' => ['number_of_rooms', 'int'],
        'Hotel_group_ID' => ['hotel_group_id', 'int'],
        'Address_Street' => 'address[street]',
        'Address_Number' => ['address[number]', 'int'],
        'Address_City' => 'address[city]',
        'Address_Postal_Code' => ['address[postal_code]', 'int'],
    ];

    public static function all() {
        $query = DB::query('SELECT * FROM Hotel');
        return DB::getCollection($query);
    }

    public static function ofHotelGroup($hotel_group_id) {
        $query = DB::query('SELECT * FROM Hotel WHERE
            Hotel_group_ID = ' . $hotel_group_id 
            );

        return DB::getCollection($query);
    }

    public function email_addresses_getter() {
        $query = DB::query('SELECT Email_Address FROM Hotel_Email_Address WHERE
            Hotel_ID = ' . $this->id);
        
        $this->email_addresses = [];
        while($row = $query->fetch_assoc()) {
            $this->email_addresses[] = $row['Email_Address'];
        }

        return $this->email_addresses;
    }

    public function phone_numbers_getter() {
        $query = DB::query('SELECT Phone_Number FROM Hotel_Phone_Number WHERE
            Hotel_ID = ' . $this->id);
        
        $this->phone_numbers = [];
        while($row = $query->fetch_assoc()) {
            $this->phone_numbers[] = $row['Phone_Number'];
        }

        return $this->phone_numbers;
    }

    public function manager_getter() {
        $query = DB::query('SELECT Employee_IRS FROM Works WHERE
            Hotel_ID = ' . $this->id .'
            AND CURDATE() BETWEEN Start_Date AND Finish_Date
            AND Position = "manager"');
        
        $managers = [];
        while($row = $query->fetch_assoc()) {
            $managers[] = $row['Position'];
        }
        if(count($managers) == 1) {
            return $managers[0];
        } else {
            die('This Hotel has '.count($managers).' Managers instead of 1.');
        }
    }

    public function addEmail($email) {
        return DB::query('INSERT INTO Hotel_Email_Address(Hotel_ID, Email_Address) VALUES
        (' . $this->id . ', "' . $email . '")');
    }

    public function deleteEmails() {
        return DB::query('DELETE FROM Hotel_Email_Address WHERE Hotel_ID = ' . $this->id);
    }

    public function addPhone($phone) {
        return DB::query('INSERT INTO Hotel_Phone_Number(Hotel_ID, Phone_Number) VALUES
            (' . $this->id . ', ' . $phone . ')');
    }

    public function deletePhones() {
        return DB::query('DELETE FROM Hotel_Phone_Number WHERE Hotel_ID = ' . $this->id);
    }

}