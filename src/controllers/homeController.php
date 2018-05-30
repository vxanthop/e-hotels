<?php

namespace controllers;

use \models\City as City;
use \models\Room as Room;

class homeController {

	public static function index() {
		return [
			'offers' => Room::offers(),
			'citynames' => City::all(),
		];
	}

}