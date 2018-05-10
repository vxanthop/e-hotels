<?php

namespace models;

class Employee extends Model {

    public $emp_IRS, $SSN, $first_name, $last_name;
    
    protected static $mapper = [
        'Employee_IRS' => ['emp_IRS', 'int'],
        'Social_Security_Number' => ['SSN', 'int'],
        'First_Name' => 'first_name',
        'Last_Name' => 'last_name',
    ];

    public function address_getter() {
        return $this->address = [
            'street' => $this->Address_Street,
            'number' => $this->Address_Number,
            'postal_code' => $this->Address_Postal_code,
            'city' => $this->Address_City
        ];
    }

    public function current_job_getter() {
        $query = DB::query('SELECT Position FROM Works WHERE
            Employee_IRS = ' . $this->emp_IRS);

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