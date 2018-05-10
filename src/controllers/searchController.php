<?php

namespace controllers;

use \models\Config as Config;
use \models\DB as DB;

class searchController {

    public static function query($vars) {
        if(!isset($vars['city']) || !isset($vars['start_date']) || !isset($vars['end_date']) || !isset($vars['capacity'])) {
            header('Location: /', true);
            die();
        }
        $data = [
            'city' => $vars['city'],
            'start_date' => $vars['start_date'],
            'end_date' => $vars['end_date'],
            'capacity' => $vars['capacity'],
            'hotel_groups' => $vars['hotel_groups'] ?? [],
            'stars' => $vars['stars'] ?? 0,
            'price_start' => $vars['price_start'] ?? 1,
            'price_end' => $vars['price_end'] ?? 300,
            'rooms_start' => $vars['rooms_start'] ?? 1,
            'rooms_end' => $vars['rooms_end'] ?? 100,
            'amenities' => $vars['amenities'] ?? [],
            'all_hotel_groups' => [
                ['id' => 2391, 'name' => 'Mainos'],
                ['id' => 1249, 'name' => 'Grande Bretagne'],
                ['id' => 1104, 'name' => 'La Reine'],
                ['id' => 1444, 'name' => 'Papadopoulos'],
            ],
            'all_amenities' => ['A/C', 'Satellite TV', 'Barbecue', 'Bathtub', 'Parking'],
        ];
        /* If no hotel groups are selected, select all instead so that query makes sense */
        if(empty($data['hotel_groups'])) {
            $data['hotel_groups'] = [];
            foreach($data['all_hotel_groups'] as $group) {
                $data['hotel_groups'][] = $group['id'];
            }
        }
        return $data;
    }

}