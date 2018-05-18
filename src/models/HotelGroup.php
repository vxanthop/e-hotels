<?php

namespace models;

class HotelGroup extends Model {

    public $id, $address, $name, $img_src, $number_of_hotels;

    protected static $table = 'Hotel_group';
    protected static $mapper = [
        'Hotel_group_ID' => ['id', 'int'],
        'Number_of_hotels' => ['number_of_hotels', 'int'],
        'Hotel_group_Name' => 'name',
        'Address_Street' => 'address[street]',
        'Address_Number' => ['address[number]', 'int'],
        'Address_City' => 'address[city]',
        'Address_Postal_Code' => ['address[postal_code]', 'int'],
    ];

    public static function all() {
        $query = DB::query('SELECT * FROM Hotel_group ORDER BY Hotel_group_Name');
        return DB::getCollection($query);
    }

    public function email_addresses_getter() {
        $query = DB::query('SELECT Email_Address FROM Hotel_group_Email_Address WHERE
            Hotel_group_ID = ' . $this->id);
        
        $this->email_addresses = [];
        while($row = $query->fetch_assoc()) {
            $this->email_addresses[] = $row['Email_Address'];
        }

        return $this->email_addresses;
    }

    public function phone_numbers_getter() {
        $query = DB::query('SELECT Phone_Number FROM Hotel_group_Phone_Number WHERE
            Hotel_group_ID = ' . $this->id);
        
        $this->phone_numbers = [];
        while($row = $query->fetch_assoc()) {
            $this->phone_numbers[] = intval($row['Phone_Number']);
        }

        return $this->phone_numbers;
    }

    public function addEmail($email) {
        return DB::query('INSERT INTO Hotel_group_Email_Address(Hotel_group_ID, Email_Address) VALUES
        (' . $this->id . ', "' . $email . '")');
    }

    public function deleteEmails() {
        return DB::query('DELETE FROM Hotel_group_Email_Address WHERE Hotel_group_ID = ' . $this->id);
    }
    
    public function addPhone($phone) {
        return DB::query('INSERT INTO Hotel_group_Phone_Number(Hotel_group_ID, Phone_Number) VALUES
            (' . $this->id . ', ' . $phone . ')');
    }

    public function deletePhones() {
        return DB::query('DELETE FROM Hotel_group_Phone_Number WHERE Hotel_group_ID = ' . $this->id);
    }

}