<?php

namespace models;

class Types {

    private $converter = NULL;

    public function __construct($type = 'string') {
        $converters = [
            'int' => 'intval',
            'string' => 'strval',
            'float' => 'floatval',
            'json' => 'json_decode',
            'boolean' => function ($value) {
                return $value == 'true';
            }
        ];
        $this->converter = $converters[$type];
    }

    public function convert($value) {
        if(!is_null($this->converter)) {
            $fun = $this->converter;
            return $fun($value);
        } else {
            return NULL;
        }
    }

}