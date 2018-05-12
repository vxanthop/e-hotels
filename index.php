<?php

require_once('src/bootstrap/one_framework.php');
require_once('src/bootstrap/loader.php');

# Used for helping with include/require commands
define('ROOT_PATH', dirname(__FILE__) . '/');


# Controllers
use \controllers\homeController as homeController;
use \controllers\searchController as searchController;
use \controllers\adminController as adminController;
use \controllers\hotelGroupController as hotelGroupController;
use \controllers\hotelController as hotelController;

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

	$errors = hotelGroupController::createSubmit($_POST);
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

	$data = hotelGroupController::view($id);
	return $app->Response('admin/hotel/listing.php', array_merge(
		$data,
		['_layout' => 'main.php']
	));

});

$app->get('/admin/hotel-group/update/:id', function ($id) use ($app) {

	$data = hotelGroupController::update($id);
	return $app->Response('admin/hotel-group/update.php', array_merge(
		$data,
		['_layout' => 'main.php']
	));

});

$app->get('/admin/hotel-group/delete/:id', function ($id) use ($app) {

	$errors = hotelGroupController::delete($id);
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

$app->get('/admin/hotel/create/:id', function ($id) use ($app) {

	$data = hotelController::create($id);
	return $app->Response('admin/hotel/create.php', array_merge(
		$data,
		['_layout' => 'main.php']
	));

});

$app->post('/admin/hotel/createSubmit/:id', function ($id) use ($app) {

	$vars = array_merge($_POST, ['hotel_group_id' => $id]);
	$errors = hotelController::createSubmit($vars);

	if(empty($errors)) {
		header('Location: /admin/hotel-group/view/' . $id);
		die();
	} else {
		foreach($errors as $error) {
			echo "$error<br>";
		}
		die();
	}

});

$app->get('/admin/hotel/update/:id', function ($id) use ($app) {

	$data = hotelController::update($id);
	return $app->Response('admin/hotel/update.php', array_merge(
		$data,
		['_layout' => 'main.php']
	));

});

$app->get('/admin/hotel/delete/:id', function ($id) use ($app) {

	$errors = hotelController::delete($id);
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