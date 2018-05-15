<?php

namespace models;

use \bootstrap\BaseModel as BaseModel;

class Model extends BaseModel {

    /*
     * @input: An associative array with entries of the format property => value that will be used to search the database table. Both schema field names and model property names can be used in place of `property`.
     * @output: If at least one entry is found, the first one is returned as an object of the called class
     */
    public static function getOne($find) {
        $clauses = self::getDBClauses($find);
        if(!$clauses) return NULL;
        $query = DB::query('SELECT * FROM ' . static::$table . ' WHERE ' . join(' AND ', $clauses));
        return DB::getOne($query, get_called_class());
    }

    /*
     * @input: An associative array with entries of the format property => value that will be used to insert into the database table. Both schema field names and model property names can be used in place of `property`.
     * @output: Returns 1 if the entry is inserted, else returns 0
     */
    public static function create($keys) {
        $db_keys = self::getDBKeys($keys);
        $insert = [];
        $values = [];
        foreach($db_keys as $key => $value) {
            if(is_bool($value)) {
                $values[] = strval(intval($value));
            } else if(is_numeric($value) && !is_string($value)) {
                $values[] = strval($value);
            } else {
                $values[] = '"' . $value . '"';
            }
            $insert[] = $key;
        }
        return DB::query('INSERT INTO ' . static::$table . '(' . join(', ', $insert) . ') VALUES (' . join(', ', $values) . ')');
    }

    /*
     * @input: An associative array $find with entries of the format `property` => value that will be used to search the database table and an associative array $replace of the same format containing the values that will be updated. Both schema field names and model property names can be used in place of `property`.
     * @output: Returns the number of entries that were updated.
     * @note: The $find array may match more than one entries and thus all of them will be updated.
     */
    public static function update($find, $replace) {
        $where = self::getDBClauses($find);
        if(!$where) return 0;
        $set = self::getDBClauses($replace);
        return DB::query('UPDATE ' . static::$table . ' SET ' . join(', ', $set) . ' WHERE ' . join(' AND ', $where));
    }

    /*
     * @input: An associative array with entries of the format property => value that will be used to search the database table. Both schema field names and model property names can be used in place of `property`.
     * @output: Returns the number of entries that were removed.
     * @note: The $find array may match more than one entries and thus all of them will be removed.
     */
    public static function delete($find) {
        $where = self::getDBClauses($find);
        if(!$where) return 0;
        return DB::query('DELETE FROM ' . static::$table . ' WHERE ' . join(' AND ', $where));
    }

}