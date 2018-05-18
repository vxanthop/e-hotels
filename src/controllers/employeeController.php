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
            'emp_IRS' => intval($vars['irs']),
            'SSN' => intval($vars['ssn']),
            'first_name' => $vars['first'],
            'last_name' => $vars['last'],
            'address' => [
                'street' => $vars['street'],
                'number' => intval($vars['number']),
                'city' => $vars['city'],
                'postal_code' => intval($vars['postal_code']),
            ],
        ];
        $query = Employee::create($create);
        if ($vars['hotel_id']){
            $emp = Employee::getOne([
                'emp_IRS' => intval($vars['irs'])
            ]); 
            $emp -> assignWork([
                'hotel_id' => $vars['hotel_id'],
                'position' => $vars['position'],
                'start_date' => $vars['start'],
                'finish_date' => $vars['finish']]);
        }
    }

    public static function update($irs) {
            $emp = Employee::getOne(['emp_IRS' => $irs]);
        return ['employee' => $emp];
    }

    public static function updateSubmit($vars) {
        $update = [
            'SSN' => intval($vars['ssn']),
            'first_name' => $vars['first'],
            'last_name' => $vars['last'],
            'address' => [
                'street' => $vars['street'],
                'number' => intval($vars['number']),
                'city' => $vars['city'],
                'postal_code' => intval($vars['postal_code']),
            ],
        ];

        $errors = [];
        $query = Employee::update([
            'emp_IRS' => intval($vars['irs'])
        ], $update);
        if(!$query) { 
            $errors[] = 'Could not update Room. Please try again.';
        }
        return $errors;
    }

    public static function delete($irs) {
        $delete = Employee::delete(['emp_IRS' => $irs]);
        $errors = [];
        if(!$delete) {
            $errors[] = 'Could not delete Employee. Please try again.';
        }
        return $errors;
    }

    public static function view($irs) {
        $emp = Employee::getOne([
            'emp_IRS' => $irs
        ]);
        $works = $emp -> positions;
        return compact('emp', 'works');
    }
}