<?php

namespace models;

use \models\Config as Config;

class DB {

	private static $_connection;
	private static $_instance; // The single instance
	private static $_host;
	private static $_username;
	private static $_password;
	private static $_database;

	private static function init() {
		if(!self::$_instance) {
			self::$_instance = new self();
		}
	}

	private function __construct() {
		/* Get authentication parameters from Config */
		self::$_host = Config::get('host');
		self::$_username = Config::get('username');
		self::$_password = Config::get('password');
		self::$_database = Config::get('database');

		/* Establish connection */
		self::$_connection = new \mysqli(self::$_host, self::$_username, 
			self::$_password, self::$_database);
	
		/* Error handling */
		if(mysqli_connect_error()) {
			trigger_error("Failed to connect to MySQL: " . mysqli_connect_error(), E_USER_ERROR);
		}
	}

	public static function query($sql) {
		self::init();
		$mysqli = self::$_connection;
		return $mysqli->query($sql);
	}

	public static function getCollection($query, $model) {
        $res = [];
        if($query) {
	        while($row = $query->fetch_object($model)) {
	            $res[] = $row;
	        }
	    }
        return $res;
	}

}