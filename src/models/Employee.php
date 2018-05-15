<?php

namespace models;

class Employee extends Model {

    public $emp_IRS, $SSN, $first_name, $last_name, $address, $position;
    
    protected static $table = 'Employee';
    protected static $mapper = [
        'Employee_IRS' => ['emp_IRS', 'int'],
        'Social_Security_Number' => 'SSN',
        'First_Name' => 'first_name',
        'Last_Name' => 'last_name',
        'Address_Street' => 'address[street]',
        'Address_Number' => ['address[number]', 'int'],
        'Address_City' => 'address[city]',
        'Address_Postal_Code' => ['address[postal_code]', 'int'],
        'Position' => 'position[title]',
        'Start_Date' => 'position[start_date]',
        'Finish_Date' => 'position[finish_date]'
    ];

    public static function ofHotel($hotel_id) {
        $query = DB::query('SELECT Employee.*, Works.Position, Works.Start_Date, Works.Finish_Date FROM Employee INNER JOIN Works ON Works.Employee_IRS = Employee.Employee_IRS WHERE Works.Hotel_ID = ' . $hotel_id . ' AND CURDATE() BETWEEN Works.Start_Date AND IFNULL(Works.Finish_Date, CURDATE())');
        return DB::getCollection($query);
    }

}