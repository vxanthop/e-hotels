<?php

require_once('src/bootstrap/one_framework.php');
require_once('src/bootstrap/loader.php');

# Used for helping with include/require commands
define('ROOT_PATH', dirname(__FILE__) . '/');


# Controllers
use \controllers\hotelController as hotelController;

# Initialize app
$app = new \OnePHP\App();



# Routes
$app->get('/', function () use ($app) {

	return $app->ResponseHTML(hotelController::index(), 200);

});



# Launch app
$app->listen();