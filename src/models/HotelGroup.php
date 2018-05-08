<?php

namespace models;

class HotelGroup extends Model {

    public $hotel_group_id, $number_of_hotels;

    protected $mapper = [
        'Hotel_Group_ID' => ['hotel_group_id', 'int'],
        'Number_of_Hotels' => ['number_of_hotels', 'int']
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
        $query = DB::query('SELECT Email_Address FROM Hotel_Group_Email_Address WHERE
            Hotel_Group_ID = ' . $this->hotel_id);
        
        $this->email_addresses = [];
        while($row = $query->fetch_assoc()) {
            $this->email_addresses[] = $row['Email_Address'];
        }

        return $this->email_addresses;
    }

    public function phone_numbers_getter() {
        $query = DB::query('SELECT Phone_Number FROM Hotel_Group_Numbers WHERE
            Hotel_Group_ID = ' . $this->hotel_group_id);
        
        $this->phone_numbers = [];
        while($row = $query->fetch_assoc()) {
            $this->phone_numbers[] = $row['Phone_Number'];
        }

        return $this->phone_numbers;
    }

}