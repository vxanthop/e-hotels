<?php

namespace controllers;

use \models\Employee as Employee;
use \models\HotelGroup as HotelGroup;
use \models\Hotel as Hotel;
use \models\Room as Room;
use \models\DB as DB;

class employeeController {

    public static function create($hotel_id = NULL) {
        if(!$hotel_id) {
            return [];
        } else {
            return [
                'hotel' => Hotel::getOne(['id' => $hotel_id]),
            ];
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
        $errors = [];
        if($query) {
            if(isset($vars['hotel_id'])) {
                $emp = Employee::getOne([
                    'emp_IRS' => intval($vars['irs'])
                ]); 
                $assign = $emp->assignWork([
                    'hotel_id' => $vars['hotel_id'],
                    'position' => $vars['position'],
                    'start_date' => $vars['start'],
                    'finish_date' => $vars['finish']
                ]);
                if(!$assign) {
                    $errors[] = 'Could not assign work to Employee. Please try again.';
                }
            }
        } else {
            $errors[] = 'Could not create Employee. Please try again.';
        }
        return $errors;
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
            $errors[] = 'Could not update Employee. Please try again.';
        }
        return $errors;
    }

    public static function move($irs) {
        $employee = Employee::getOne([
            'emp_IRS' => $irs
        ]);
        if(isset($_GET['hotel_group_id'])) {
            $group = HotelGroup::getOne([
                'id' => intval($_GET['hotel_group_id'])
            ]);
            return [
                'employee' => $employee,
                'group' => $group,
                'hotels' => Hotel::ofHotelGroup($group->id)
            ];
        } else {
            $groups = HotelGroup::all();
            return [
                'employee' => $employee,
                'groups' => $groups
            ];
        }
    }

    public static function moveSubmit($vars) {
        $employee = Employee::getOne([
            'emp_IRS' => intval($vars['emp_IRS']),
        ]);
        $errors = [];
        if($employee->quit()) {
            $assign = $employee->assignWork(
                intval($vars['hotel_id']),
                $vars['position'],
                $vars['start_date'],
                $vars['finish_date']
            );
            if(!$assign) {
                $errors[] = 'Could not assign work to Employee. Please try again.';
            }
        } else {
            $errors[] = 'Could not quit job for Employee. Please try again.';
        }
        return $errors;
    }

    public static function quit($irs) {
        $employee = Employee::getOne([
            'emp_IRS' => $irs,
        ]);
        $errors = [];
        if(!$employee->quit()) {
            $errors[] = 'Could not quit job for Employee. Please try again.';
        }
        return $errors;
    }

    public static function view($irs) {
        $employee = Employee::getOne([
            'emp_IRS' => $irs
        ]);
        return ['employee' => $employee];
    }

}