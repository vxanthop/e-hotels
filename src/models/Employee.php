<?php

namespace models;

class Employee extends Model {

    public $emp_IRS, $SSN, $first_name, $last_name, $address, $current_job;
    
    protected static $table = 'Employee';
    protected static $mapper = [
        'Employee_IRS' => 'emp_IRS',
        'Social_Security_Number' => 'SSN',
        'First_Name' => 'first_name',
        'Last_Name' => 'last_name',
        'Address_Street' => 'address[street]',
        'Address_Number' => ['address[number]', 'int'],
        'Address_City' => 'address[city]',
        'Address_Postal_Code' => ['address[postal_code]', 'int'],
        'Position' => 'current_job[position]',
        'Hotel_ID' => 'current_job[hotel_id]',
        'Start_Date' => ['current_job[start_date]', 'date'],
        'Finish_Date' => ['current_job[finish_date]', 'date'],
    ];

    public static function all() {
        $query = DB::query('SELECT * FROM Employee');
        return DB::getCollection($query);
    }

    public static function getOne($find) {
        $employee = parent::getOne($find);
        $query = DB::query('SELECT Hotel_ID, Start_Date, Finish_Date, Position FROM Works WHERE Employee_IRS = ' . $employee->emp_IRS . ' AND CURDATE() BETWEEN Start_Date AND Finish_Date');
        if(!$query) {
            return NULL;
        }
        $job = $query->fetch_assoc();
        if($job) {
            $employee->current_job = [
                'hotel_id' => $job['Hotel_ID'],
                'start_date' => $job['Start_Date'],
                'finish_date' => $job['Finish_Date'],
                'position' => $job['Position'],
            ];
        }
        return $employee;
    }

    public static function searchInHotel($name, $hotel_id){
        $query = DB::query('SELECT Employee.*, Works.Position FROM Employee INNER JOIN Works ON Works.Employee_IRS = Employee.Employee_IRS WHERE Works.Hotel_ID = ' . $hotel_id . ' AND Employee.First_Name = \'' . $name['first_name'] . '\' AND Employee.Last_Name = \'' . $name['last_name'] . '\'');
        return DB::getCollection($query);
    }

    public static function ofHotel($hotel_id) {
        $query = DB::query('SELECT Employee.*, Works.* FROM Employee INNER JOIN Works ON Works.Employee_IRS = Employee.Employee_IRS WHERE Works.Hotel_ID = ' . $hotel_id . ' AND CURDATE() BETWEEN Works.Start_Date AND Works.Finish_Date');
        return DB::getCollection($query);
    }

    public static function managersOfHotel($hotel_id) {
        $query = DB::query('SELECT Employee.*, Works.* FROM Employee INNER JOIN Works ON Works.Employee_IRS = Employee.Employee_IRS WHERE Works.Hotel_ID = ' . $hotel_id . ' AND Position = \'manager\' ORDER BY Works.Start_Date');
        return DB::getCollection($query);
    }

    public function quit() {
        return DB::query('UPDATE Works SET Finish_Date = DATE(\'' . date('Y-m-d', strtotime('-1 day')) . '\') WHERE Employee_IRS = ' . $this->emp_IRS . ' AND Finish_Date >= DATE(\'' . date('Y-m-d') . '\') LIMIT 1');
    }

    public function assignWork($hotel_id, $position, $start_date, $finish_date) {
        return DB::query('INSERT INTO Works VALUES
        (' . $this->emp_IRS. ', ' . $hotel_id . ', DATE("' . $start_date . '"), DATE("' . $finish_date . '"), "' . $position . '")');
    }

    public function fullname_getter() {
        return $this->fullname = $this->first_name . " " . $this->last_name;
    }

    public function jobs_getter() {
        $query = DB::query('SELECT * FROM Works WHERE Employee_IRS = ' . $this->emp_IRS . ' ORDER BY Start_Date DESC');
        
        $this->jobs = [];
        while($row = $query->fetch_assoc()) {
            if($row['Finish_Date'] >= date('Y-m-d')) {
                $status = 'Current job';
            } else {
                $status = 'Past job';
            }
            $job = [
                'hotel' => Hotel::getOne([
                    'id' => intval($row['Hotel_ID'])
                ]),
                'start_date' => $row['Start_Date'],
                'finish_date' => $row['Finish_Date'],
                'position' => $row['Position'],
                'status' => $status,
            ];
            $this->jobs[] = $job;
        }

        return $this->jobs;
    }

}