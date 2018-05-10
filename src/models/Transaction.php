<?php

namespace models;

class Transaction extends Model {

    public $transaction_id, $cust_IRS, $emp_IRS, $room_id, $hotel_id, $payment_amount, $payment_method;

    protected static $mapper = [
        'Payment_Transaction_ID' => ['transaction_id', 'int'],
        'Hotel_ID' => ['hotel_id', 'int'],
        'Room_ID' => ['room_id', 'int'],
        'Employee_IRS' => ['emp_IRS', 'int'],
        'Customer_IRS' => ['cust_IRS', 'int'],
        'Payment_Amount' => ['payment_amount', 'float'],
        'Payment_Method' => 'payment_method'
    ];

}