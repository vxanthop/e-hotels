<?php

namespace controllers;

use \models\Config as Config;
use \models\DB as DB;

class homeController {

	public static function index() {
		return [
			'description' => 'Choose from 27 different destinations!',
			'offers' => [
				['city' => 'Athens', 'price' => 34],
				['city' => 'Rethymno', 'price' => 33],
				['city' => 'Santorini', 'price' => 41],
				['city' => 'Kerkyra', 'price' => 30],
				['city' => 'Thessaloniki', 'price' => 30],
				['city' => 'Alexandroupoli', 'price' => 28]
			]
		];
	}

}