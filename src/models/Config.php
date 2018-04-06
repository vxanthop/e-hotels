<?php

namespace models;

class Config {

	private static $settings;

	public function __construct() {
		self::$settings = include ROOT_PATH . 'settings.php';
	}

	public function get($attr) {
		return self::$settings[$attr] ?? null;
	}

}