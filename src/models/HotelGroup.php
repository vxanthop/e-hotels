<?php

namespace models;

class HotelGroup extends Model {

    public $id, $name, $img_src, $number_of_hotels;

    protected $mapper = [
        'Hotel_group_ID' => ['hotel_group_id', 'int'],
        'Number_of_hotels' => ['number_of_hotels', 'int'],
        'Hotel_group_Name' => 'name',
    ];

    public static function all() {
        $query = DB::query('SELECT * FROM Hotel_group');
        return DB::getCollection($query);
    }

    public function address_getter() {
        return $this->address = [
            'street' => $this->Address_Street,
            'number' => intval($this->Address_Number),
            'postal_code' => intval($this->Address_Postal_Code),
            'city' => $this->Address_City
        ];
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

}