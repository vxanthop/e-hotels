<?php

namespace controllers;

use \models\HotelGroup as HotelGroup;
use \models\Room as Room;
use \models\Amenity as Amenity;
use \models\City as City;

class searchController {

    public static function query($vars) {
        if(!isset($vars['city']) || !isset($vars['start_date']) || !isset($vars['end_date']) || !isset($vars['capacity'])) {
            header('Location: /', true);
            die();
        }
        $citynames = [];
		foreach(City::all() as $city) {
			$citynames[] = $city['city'];
		}
        $data = [
            'city' => $vars['city'],
            'start_date' => $vars['start_date'],
            'end_date' => $vars['end_date'],
            'capacity' => $vars['capacity'] ?? 0,
            'hotel_groups' => $vars['hotel_groups'] ?? [],
            'stars' => $vars['stars'] ?? 0,
            'rooms_start' => $vars['rooms_start'] ?? 1,
            'rooms_end' => $vars['rooms_end'] ?? 100,
            'amenities' => $vars['amenities'] ?? [],
            'all_hotel_groups' => HotelGroup::all(),
            'all_amenities' => Amenity::all()
        ];
        $data['results'] = Room::search($data);
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