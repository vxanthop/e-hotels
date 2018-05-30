<?php

namespace models;

class City {
    
    /*
        @input: None
        @output: Array of city name
    */
    public static function all() {
        $query = DB::query('SELECT DISTINCT Address_City FROM Hotel');
        $cities = [];
        /*  For each result in the query, fetch_assoc() will return an associative array
            like ['amenity' => value]
        */
        while($row = $query->fetch_assoc()) {
            $cities[] = $row['Address_City'];
        }
        return $cities;
    }

}