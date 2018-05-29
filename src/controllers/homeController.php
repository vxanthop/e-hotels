<?php

namespace controllers;

use \models\City as City;
use \models\Room as Room;

class homeController {

	public static function index() {
		$citynames = [];
		$rooms_per_city = [];
		foreach(City::all() as $city) {
			$citynames[] = $city['city'];
			$rooms_per_city[$city['city']] = $city['availableRoomsNum'];
		}
		return [
			'offers' => Room::offers(),
			'citynames' => $citynames,
			'rooms_per_city' => $rooms_per_city,
		];
	}

}