<?php

namespace models;

class Employee extends Model {

    public $emp_IRS, $SSN, $first_name, $last_name, $address;
    
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
    ];

    public function current_job_getter() {
        $query = DB::query('SELECT Position FROM Works WHERE
            Employee_IRS = ' . $this->emp_IRS .'
        AND CURDATE() BETWEEN Start_Date AND IFNULL(Finish_Date, CURDATE())');

        $current_jobs = [];
        while($row = $query->fetch_assoc()) {
            $current_jobs[] = $row['Position'];
        }
        if(count($current_jobs) == 1) {
            return $current_jobs[0];
        } else {
            die('This Employee has '.count($current_jobs).' jobs instead of 1.');
        }
    }

}