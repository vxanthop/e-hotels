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

}