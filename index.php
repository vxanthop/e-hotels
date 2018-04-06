<?php

require_once('src/bootstrap/one_framework.php');
require_once('src/bootstrap/loader.php');

# Used for helping with include/require commands
define('ROOT_PATH', dirname(__FILE__) . '/');

# Models
use \models\DB as DB;
use \models\Config as Config;

# Controllers
use \controllers\hotelController as hotelController;

# Initialize app
$app = new \OnePHP\App();
$config = new Config();



# Routes
$app->get('/', function () use ($app) {

	$hotelController = new hotelController();
	return $app->ResponseHTML($hotelController->index(), 200);

});



# Launch app
$app->listen();