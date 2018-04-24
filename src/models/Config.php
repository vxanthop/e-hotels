<?php

namespace models;

class Config {

	private static $settings;

    private static function init() {
        if(!self::$settings) {
            self::$settings = include ROOT_PATH . 'settings.php';
        }
    }

	public static function get($attr) {
        self::init();
		return self::$settings[$attr] ?? null;
	}

}