<?php

namespace models;

class Transaction extends Model {

    public $rent_id, $payment_amount, $payment_method;

    protected static $table = 'Payment_Transaction';
    protected static $mapper = [
        'Rent_ID' => ['rent_id', 'int'],
        'Payment_Amount' => ['payment_amount', 'float'],
        'Payment_Method' => 'payment_method'
    ];

}