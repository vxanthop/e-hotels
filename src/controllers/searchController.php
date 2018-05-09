<?php

namespace controllers;

use \models\Config as Config;
use \models\DB as DB;

class searchController {

    public static function query($query) {
        $data = [
            'all_hotel_groups' => [
                ['id' => 2391, 'name' => 'Mainos'],
                ['id' => 1249, 'name' => 'Grande Bretagne'],
                ['id' => 1104, 'name' => 'La Reine'],
                ['id' => 1444, 'name' => 'Papadopoulos'],
            ],
            'all_amenities' => ['A/C', 'Satellite TV', 'Barbecue', 'Bathtub', 'Parking'],
        ];
        /* If no hotel groups are selected, select all instead so that query makes sense */
        if(empty($query['hotel_groups'])) {
            $query['hotel_groups'] = [];
            foreach($data['all_hotel_groups'] as $group) {
                $query['hotel_groups'][] = $group['id'];
            }
        }
        return array_merge($query, $data);
    }

}