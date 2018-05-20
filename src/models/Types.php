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
            'date' => 'strval',
            'boolean' => function ($value) {
                return !!$value;
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

    public static function getAutoType($auto) {
        if(is_bool($auto)) {
            return 'boolean';
        }
        if(is_numeric($auto) && !is_string($auto)) {
            return 'int';
        }
        return 'string';
    }

}