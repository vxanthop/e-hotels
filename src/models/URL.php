<?php

namespace models;

class URL {

    public static function addQuery($url, $params) {
        $p = parse_url($url); 
        return $p['path'] . '?' . $p['query'] . http_build_query($params);
    }

}