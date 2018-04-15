<?php

namespace models;

use \models\Types as Types;

class Model {

    private $data;

    public function __construct() {
        if(isset($this->mapper)) {
            $this->mapProperties($this->mapper);
        }
    }

    private function mapProperties($mapper) {
        foreach($this->data as $key => $value) {
            if(isset($mapper[$key])) {
                $t = $mapper[$key];
                if(is_array($t)) {
                    $field = $t[0];
                    $type = new Types($t[1]);
                    $v = $type->convert($value);
                } else if(is_string($t)) {
                    $field = $t;
                    $v = $value;
                }
            } else {
                $field = $key;
                $v = $value;
            }
            if(!property_exists($this, $field)) {
                trigger_error(get_class($this) . " has no property \"" . $field . "\".", E_USER_ERROR);
            }
            $this->$field = $v;
        }
        $this->data = [];
    }

    public function __set($name, $value) {
        if(!isset($this->mapper)) {
            $this->$name = $value;
        } else {
            $this->data[$name] = $value;
        }
    }

}