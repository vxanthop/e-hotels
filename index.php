<?php

require_once('src/bootstrap/one_framework.php');
require_once('src/bootstrap/loader.php');

# Used for helping with include/require commands
define('ROOT_PATH', dirname(__FILE__) . '/');


# Controllers
use \controllers\homeController as homeController;
use \controllers\searchController as searchController;
use \controllers\adminController as adminController;

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

/* Search */

$app->get('/search', function () use ($app) {

	$data = searchController::query($_GET);
	return $app->Response('query.php', array_merge(
		$data,
		['_layout' => 'main.php']
	));

});


/* Admin */

$app->get('/admin', function () use ($app) {

	$data = adminController::index();
	return $app->Response('admin/index.php', array_merge(
		$data,
		['_layout' => 'main.php']
	));

});

$app->get('/admin/hotel-group/create', function () use ($app) {
	return $app->Response('admin/hotel-group/create.php', ['_layout' => 'main.php']);
});

$app->post('/admin/hotel-group/createSubmit', function () use ($app) {

	$errors = adminController::hotelGroupCreateSubmit($_POST);
	if(empty($errors)) {
		header('Location: /admin');
		die();
	} else {
		foreach($errors as $error) {
			echo "$error<br>";
		}
		die();
	}

});

$app->get('/admin/hotel-group/view/:id', function ($id) use ($app) {

	$data = adminController::hotelGroupView($id);
	return $app->Response('admin/hotel/listing.php', array_merge(
		$data,
		['_layout' => 'main.php']
	));

});

$app->get('/admin/hotel-group/delete/:id', function ($id) use ($app) {

	$errors = adminController::hotelGroupDelete($id);
	if(empty($errors)) {
		header('Location: /admin');
		die();
	} else {
		foreach($errors as $error) {
			echo "$error<br>";
		}
		die();
	}

});


# Launch app
$app->listen();