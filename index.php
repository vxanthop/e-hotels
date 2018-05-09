<?php

require_once('src/bootstrap/one_framework.php');
require_once('src/bootstrap/loader.php');

# Used for helping with include/require commands
define('ROOT_PATH', dirname(__FILE__) . '/');


# Controllers
use \controllers\homeController as homeController;
use \controllers\searchController as searchController;

# Initialize app
$app = new \OnePHP\App();



# Routes
$app->get('/', function () use ($app) {

	$data = homeController::index();
	return $app->Response('home.php', array_merge(
		$data,
		['_layout' => 'main.php']
	));

});

$app->get('/search', function () use ($app) {

	$data = searchController::query([
		'city' => $_GET['city'],
		'start_date' => $_GET['start_date'],
		'end_date' => $_GET['end_date'],
		'capacity' => $_GET['capacity'],
		'hotel_groups' => $_GET['hotel_groups'] ?? [],
		'stars' => $_GET['stars'] ?? 0,
		'price_start' => $_GET['price_start'] ?? 1,
		'price_end' => $_GET['price_end'] ?? 300,
		'rooms_start' => $_GET['rooms_start'] ?? 1,
		'rooms_end' => $_GET['rooms_end'] ?? 100,
		'amenities' => $_GET['amenities'] ?? [],
	]);
	return $app->Response('query.php', array_merge(
		$data,
		['_layout' => 'main.php']
	));

});



# Launch app
$app->listen();