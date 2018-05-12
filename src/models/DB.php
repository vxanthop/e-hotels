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

	private static function getClassFromBacktrace() {
		$trace = debug_backtrace();
		if(!isset($trace[2]['class']) || !class_exists($trace[2]['class'])) {
			trigger_error("Could not guess caller class from the backtrace. Try passing it explicitly as an argument.", E_USER_ERROR);
			return NULL;
		}
		return $trace[2]['class'];
	}

	public static function query($sql) {
		self::init();
		$mysqli = self::$_connection;
		return $mysqli->query($sql);
	}

	public static function insert_id() {
		self::init();
		$mysqli = self::$_connection;
		return $mysqli->insert_id;
	}

	public static function getCollection($query, $model = NULL) {
		if(is_null($model)) {
			$model = DB::getClassFromBacktrace();
		}
        $res = [];
        if($query) {
	        while($row = $query->fetch_object($model)) {
	            $res[] = $row;
	        }
	    }
        return $res;
	}

	public static function getOne($query, $model = NULL) {
		if(is_null($model)) {
			$model = DB::getClassFromBacktrace();
		}
		if($query) {
			return $query->fetch_object($model);
		} else {
			return NULL;
		}
	}

}