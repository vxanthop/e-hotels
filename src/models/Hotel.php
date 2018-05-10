<?php

namespace models;

class Hotel extends Model {

    public $hotel_id, $hotel_group_id, $stars, $number_of_rooms;

    protected static $mapper = [
        'Hotel_ID' => ['hotel_id', 'int'],
        'Stars' => ['stars', 'int'],
        'Number_of_rooms' => ['number_of_rooms', 'int'],
        'Hotel_group_ID' => ['hotel_group_id', 'int']
    ];

    public function address_getter() {
        return $this->address = [
            'street' => $this->Address_Street,
            'number' => $this->Address_Number,
            'postal_code' => $this->Address_Postal_code,
            'city' => $this->Address_City
        ];
    }

    public function email_addresses_getter() {
        $query = DB::query('SELECT Email_Address FROM Hotel_Email_Address WHERE
            Hotel_ID = ' . $this->hotel_id);
        
        $this->email_addresses = [];
        while($row = $query->fetch_assoc()) {
            $this->email_addresses[] = $row['Email_Address'];
        }

        return $this->email_addresses;
    }

    public function phone_numbers_getter() {
        $query = DB::query('SELECT Phone_Number FROM Hotel_Phone_number WHERE
            Hotel_ID = ' . $this->hotel_id);
        
        $this->phone_numbers = [];
        while($row = $query->fetch_assoc()) {
            $this->phone_numbers[] = $row['Phone_Number'];
        }

        return $this->phone_numbers;
    }

}