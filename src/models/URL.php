<?php

namespace models;

class URL {

    public static function addQuery($url, $params) {
        $p = parse_url($url);
        if(strlen($p['query'])) {
            $query = '?' . $p['query'] . '&' . http_build_query($params);
        } else {
            $query = '?' . http_build_query($params);
        }
        return $p['path'] . $query;
    }

}