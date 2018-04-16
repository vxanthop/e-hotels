<?php

namespace bootstrap;

use \models\Types as Types;

class BaseModel {

    private $data = [];
    protected $mapper = [];

    /*  mysqli_fetch_object first assigns the properties by using __set
        and then calls the constructor. When the object is constructed,
        call the mapProperties helper to properly assign the model properties */
    public function __construct() {
        if(isset($this->mapper)) {
            $this->mapProperties($this->mapper);
        }
    }

    private function mapProperties($mapper) {
        /*  Workaround for properties that are to be mapped to the same name
            but with different type */
        foreach($mapper as $old => $new) {
            if(is_array($new) && $old == $new[0]) {
                $type = new Types($new[1]);
                if(isset($this->data[$old])) {
                    $this->$old = $type->convert($this->data[$old]);
                } else if(isset($this->$old)) {
                    $this->$old = $type->convert($this->$old);
                }
                unset($mapper[$old]);
            }
        }
        /*  Process $this->data properties that were fetched from the DB and "move" them
            to the object properties with the given type */
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

    /* Computed property processor */
    public function __get($name) {
        if(method_exists($this, $name . '_getter')) {
            return call_user_func_array([$this, $name . '_getter'], []);
        } else {
            trigger_error(get_class($this) . " has no property \"" . $name . "\". If you want to use a computed property, declare a public method named \"{$name}_getter\".", E_USER_ERROR);
        }
    }

    /*  mysqli_fetch_object uses __set to assign properties to the object.
        Override default behavior to store assigned properties in $this->data instead. */
    public function __set($name, $value) {
        if(!isset($this->mapper[$name])) {
            $this->$name = $value;
        } else {
            $this->data[$name] = $value;
        }
    }

}