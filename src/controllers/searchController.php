<?php

namespace controllers;

use \models\HotelGroup as HotelGroup;
use \models\Room as Room;
use \models\Amenity as Amenity;
use \models\City as City;

class searchController {

    public static function query($vars) {
        $citynames = City::all();
        $view = $vars['view'] ?? 'rooms';
        if(!isset($vars['view'])) {
            if(!$vars['city']) {
                $view = 'per_city';
            } else {
                $view = 'rooms';
            }
        } else {
            $view = $vars['view'];
        } 
        $data = [
            'city' => $vars['city'],
            'start_date' => $vars['start_date'],
            'end_date' => $vars['end_date'],
            'capacity' => $vars['capacity'] ?? 0,
            'view' => $view,
            'hotel_groups' => $vars['hotel_groups'] ?? [],
            'stars' => $vars['stars'] ?? 0,
            'price_min' => $vars['price_min'] ?? 1,
            'price_max' => $vars['price_max'] ?? 300,
            'rooms_num' => $vars['rooms_num'] ?? 1,
            'amenities' => $vars['amenities'] ?? [],
            'all_hotel_groups' => HotelGroup::all(),
            'all_amenities' => Amenity::all()
        ];
        if(!isset($vars['start_date']) || !isset($vars['end_date']) || !isset($vars['capacity'])) {
            $data['results'] = [];
        } else {
            if($data['view'] == 'rooms') {
                $data['results'] = Room::search($data);
            } else {
                $data['results'] = Room::searchPerCity($data);
            }
        }
        $data['citynames'] = $citynames;
        /* If no hotel groups are selected, select all instead so that query makes sense */
        if(empty($data['hotel_groups'])) {
            $data['hotel_groups'] = [];
            foreach($data['all_hotel_groups'] as $group) {
                $data['hotel_groups'][] = $group->id;
            }
        }
        return $data;
    }

}