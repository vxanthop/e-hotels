<?php

namespace models;

class Customer extends Model {

    public $cust_IRS, $SSN, $first_name, $last_name, $first_registration;
    
    protected static $mapper = [
        'Customer_IRS' => ['cust_IRS', 'int'],
        'Social_Security_Number' => ['SSN', 'int'],
        'Last_name' => ['last_name', 'strg'],
        'First_Registration' => 'first_registration'
    ];

    public function address_getter() {
        return $this->address = [
            'street' => $this->Address_Street,
            'number' => $this->Address_Number,
            'postal_code' => $this->Address_Postal_code,
            'city' => $this->Address_City
        ];
    }

}