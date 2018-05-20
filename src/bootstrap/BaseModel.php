<?php

namespace bootstrap;

use \models\DB as DB;
use \models\Types as Types;

class BaseModel {

    private $data = [];
    protected static $mapper, $inverseMapper, $table;

    /*  mysqli_fetch_object first assigns the properties by using __set
        and then calls the constructor. When the object is constructed,
        call the mapProperties helper to properly assign the model properties */
    public function __construct() {
        if(isset(static::$mapper)) {
            $this->mapProperties(static::$mapper);
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
            /* 
                Match mappers of array[key] format.
                TODO: Make it work for nested arrays array[key1][key2][this_key]
            */
            preg_match('/(\w+)\[(\w+)\]/', $field, $matches);
            if(count($matches)) {
                $field = $matches[1];
                $subfield = $matches[2];
                if(!property_exists($this, $matches[1])) {
                    trigger_error(get_class($this) . " has no property \"" . $matches[1] . "\".", E_USER_ERROR);
                }
                $this->$field[$subfield] = $v;
            } else {
                if(!property_exists($this, $field)) {
                    trigger_error(get_class($this) . " has no property \"" . $field . "\".", E_USER_ERROR);
                }
                $this->$field = $v;
            }
        }
        $this->data = [];
    }

    private static function invertMapper() {
        if(isset(static::$mapper)) {
            foreach(static::$mapper as $key => $t) {
                if(is_array($t)) {
                    $field = $t[0];
                    $type = $t[1];
                } else if(is_string($t)) {
                    $field = $t;
                    $type = 'string';
                }
                self::$inverseMapper[$field] = [$key, $type];
            }
        }
    }

    public static function getDBKeyValues($data) {
        self::invertMapper();
        $db_keys = [];
        foreach($data as $key => $value) {
            if(is_array($value)) {
                foreach($value as $k => $v) {
                    $mapper_key = $key . '[' . $k . ']';
                    if(isset(self::$inverseMapper[$mapper_key])) {
                        $field = self::$inverseMapper[$mapper_key][0];
                        $db_keys[$field] = [$v, self::$inverseMapper[$mapper_key][1]];
                    }
                }
            } else {
                if(isset(self::$inverseMapper[$key])) {
                    $field = self::$inverseMapper[$key][0];
                    $db_keys[$field] = [$value, self::$inverseMapper[$key][1]];
                } else {
                    $db_keys[$key] = [$value, 'auto'];
                }
            }
        }
        return $db_keys;
    }

    private static function toDBValue($value, $type) {
        if($value == null) {
            return 'NULL';
        }
        if($type == 'auto') {
            $type = Types::getAutoType($value);
        }
        switch($type) {
            case 'int':
            case 'float':
                return strval($value);
            case 'boolean':
                return strval(intval($value));
            case 'string':
            case 'json':
                return '\'' . DB::escape($value) . '\'';
            case 'date':
                return 'DATE(\'' . DB::escape($value) . '\')';
            default:
                return '';
        }
    }

    public static function getDBClausesInsert($data) {
        $db_keyvalues = self::getDBKeyValues($data);
        $insert = [];
        $values = [];
        foreach($db_keyvalues as $key => $t) {
            [$value, $type] = $t;
            $v = self::toDBValue($value, $type);
            if(strlen($v)) {
                $values[] = $v;
                $insert[] = $key;
            }
        }
        return compact('insert', 'values');
    }

    public static function getDBClauses($keys) {
        $db_keyvalues = self::getDBKeyValues($keys);
        $clauses = [];
        foreach($db_keyvalues as $key => $t) {
            [$value, $type] = $t;
            $v = self::toDBValue($value, $type);
            if(strlen($v)) {
                $clauses[] = $key . ' = ' . $v;
            }
        }
        return $clauses;
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
        if(!isset(static::$mapper[$name])) {
            $this->$name = $value;
        } else {
            $this->data[$name] = $value;
        }
    }

}