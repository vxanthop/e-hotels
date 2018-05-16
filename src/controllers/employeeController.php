<?php

namespace controllers;

use \models\Employee as Employee;
use \models\Hotel as Hotel;
use \models\Room as Room;
use \models\DB as DB;

class employeeController {


    public static function create($hotel_id = NULL) {
        if (!$hotel_id){
            return [];
        }
        else{
            $data=[
                'hotel'=> Hotel::getOne(['id' => $hotel_id]),
            ];
            return $data;  
        }
    }

    public static function createSubmit($vars) {
        $create = [
            'emp_IRS' => $vars['emp_IRS'],
            'SSN' => $vars['SSN'],
            'first_name' => $vars['first_name'],
            'last_name' => $vars['last_name'],
            'address' => [
                'street' => $vars['street'],
                'number' => intval($vars['number']),
                'city' => $vars['city'],
                'postal_code' => intval($vars['postal_code']),
            ],
        ];
        $query = Employee::create($create);     
    }

    public static function update($irs) {
        $emp = Employee::getOne([
            'irs' => $irs
        ]);
        return $emp;
    }

    public static function updateSubmit($vars) {
        $update = [
            'SSN' => $vars['SSN'],
            'first_name' => $vars['first_name'],
            'last_name' => $vars['last_name'],
            'address' => [
                'street' => $vars['street'],
                'number' => intval($vars['number']),
                'city' => $vars['city'],
                'postal_code' => intval($vars['postal_code']),
            ],
        ];

        $query = Employee::update([
            'irs' => $vars['irs']
        ], $update);
    }

    public static function delete($irs) {
        $delete = Employee::delete(['irs' => $irs]);
        $errors = [];
        if(!$delete) {
            $errors[] = 'Could not delete Room. Please try again.';
        }
        return $errors;
    }

    public static function view($irs) {
        $emp = Employee::getOne([
            'emp_IRS' => $irs
        ]);
        $works = $emp -> positions;
        var_dump($emp, $works);
        die();
        return compact('emp', 'work');
    }
}