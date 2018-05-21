<?php

namespace controllers;

use \models\Config as Config;
use \models\DB as DB;
use \models\City as City;

class homeController {

	public static function index() {
		$citynames = [];
		$rooms_per_city = [];
		foreach(City::all() as $city) {
			$citynames[] = $city['city'];
			$rooms_per_city[$city['city']] = $city['availableRoomsNum'];
		}
		return [
			'offers' => [
				['city' => 'Athens', 'price' => 34],
				['city' => 'Rethymno', 'price' => 33],
				['city' => 'Santorini', 'price' => 41],
				['city' => 'Kerkyra', 'price' => 30],
				['city' => 'Thessaloniki', 'price' => 30],
				['city' => 'Alexandroupoli', 'price' => 28]
			],
			'citynames' => $citynames,
			'rooms_per_city' => $rooms_per_city,
		];
	}

}