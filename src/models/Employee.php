<?php

namespace models;

class Employee extends Model {

    public $emp_IRS, $SSN, $first_name, $last_name, $address, $current_job;
    
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
        'Position' => 'current_job[position]',
        'Hotel_ID' => 'current_job[hotel_id]',
        'Start_Date' => 'current_job[start_date]',
        'Finish_Date' => 'current_job[finish_date]',
    ];

    public static function all() {
        $query = DB::query('SELECT Employee.*, Works.* FROM Employee INNER JOIN Works ON Works.Employee_IRS = Employee.Employee_IRS WHERE CURDATE() BETWEEN Works.Start_Date AND IFNULL(Works.Finish_Date, CURDATE())');
        return DB::getCollection($query);
    }

    public static function ofHotel($hotel_id) {
        $query = DB::query('SELECT Employee.*, Works.* FROM Employee INNER JOIN Works ON Works.Employee_IRS = Employee.Employee_IRS WHERE Works.Hotel_ID = ' . $hotel_id . ' AND CURDATE() BETWEEN Works.Start_Date AND IFNULL(Works.Finish_Date, CURDATE())');
        return DB::getCollection($query);
    }

    public function positions_getter() {
        $query = DB::query('SELECT Employee.*, Works.* FROM Employee INNER JOIN Works ON Works.Employee_IRS = Employee.Employee_IRS WHERE Works.Employee_IRS = '.$this->irs . 'ORDER BY Start_Date');
        
        $this->positions = [];
        while($row = $query->fetch_assoc()) {
            $this->positions[] = $row['Position'];
        }

        return $this->positions;
    }
}