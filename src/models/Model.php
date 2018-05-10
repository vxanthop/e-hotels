<?php

namespace models;

use \bootstrap\BaseModel as BaseModel;

class Model extends BaseModel {

    public static function getOne($keys) {
        $clauses = self::getDBClauses($keys);
        if(!$clauses) return NULL;
        $query = DB::query('SELECT * FROM ' . static::$table . ' WHERE ' . join(' AND ', $clauses));
        return DB::getOne($query, get_called_class());
    }

    public static function create($keys) {
        $db_keys = self::getDBKeys($keys);
        $insert = '';
        $values = '';
        foreach($db_keys as $key => $value) {
            if(is_numeric($value) && !is_string($value)) {
                $valuei = strval($value);
            } else {
                $valuei = '"' . $value . '"';
            }
            if($insert) {
                $insert .= ', ' . $key;
            } else {
                $insert = $key;
            }
            if($values) {
                $values .= ', ' . $valuei;
            } else {
                $values = $valuei;
            }
        }
        return DB::query('INSERT INTO ' . static::$table . '(' . $insert . ') VALUES (' . $values . ')');
    }

    public static function update($find, $replace) {
        $where = self::getDBClauses($find);
        if(!$where) return 0;
        $set = self::getDBClauses($replace);
        return DB::query('UPDATE ' . static::$table . ' SET ' . join(', ', $set) . ' WHERE ' . join(' AND ', $where));
    }

    public static function delete($keys) {
        $where = self::getDBClauses($keys);
        if(!$where) return 0;
        return DB::query('DELETE FROM ' . static::$table . ' WHERE ' . join(' AND ', $where));
    }

}