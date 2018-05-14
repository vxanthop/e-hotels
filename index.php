<?php

require_once('src/bootstrap/one_framework.php');
require_once('src/bootstrap/loader.php');

# Used for helping with include/require commands
define('ROOT_PATH', dirname(__FILE__) . '/');

session_start();

# Controllers
use \controllers\homeController as homeController;
use \controllers\searchController as searchController;
use \controllers\adminController as adminController;
use \controllers\hotelGroupController as hotelGroupController;
use \controllers\hotelController as hotelController;

# Models
use \models\Config as Config;
use \models\URL as URL;

error_reporting(Config::get('error-level'));

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
	if(isset($_GET['errors'])) {
		$data['errors'] = $_GET['errors'];
	}
	return $app->Response('admin/index.php', array_merge(
		$data,
		['_layout' => 'main.php']
	));

});

$app->get('/admin/hotel-group/create', function () use ($app) {

	$data = [];
	if(isset($_GET['errors'])) {
		$data['errors'] = $_GET['errors'];
	}
	return $app->Response('admin/hotel-group/create.php', array_merge(
		$data,
		['_layout' => 'main.php']
	));

});

$app->post('/admin/hotel-group/create', function () use ($app) {

	$errors = hotelGroupController::createSubmit($_POST);
	if(empty($errors)) {
		header('Location: /admin');
		die();
	} else {
		header('Location: ' . URL::addQuery($_GET['return'], ['errors' => $errors]));
		die();
	}

});

$app->get('/admin/hotel-group/:id', function ($id) use ($app) {

	$data = hotelGroupController::view($id);
	if(isset($_GET['errors'])) {
		$data['errors'] = $_GET['errors'];
	}
	return $app->Response('admin/hotel/listing.php', array_merge(
		$data,
		['_layout' => 'main.php']
	));

});

$app->get('/admin/hotel-group/update/:id', function ($id) use ($app) {

	$data = hotelGroupController::update($id);
	if(isset($_GET['errors'])) {
		$data['errors'] = $_GET['errors'];
	}
	return $app->Response('admin/hotel-group/update.php', array_merge(
		$data,
		['_layout' => 'main.php']
	));

});

$app->post('/admin/hotel-group/update/:id', function ($id) use ($app) {

	$vars = array_merge($_POST, ['hotel_group_id' => $id]);
	$errors = hotelGroupController::updateSubmit($vars);
	if(empty($errors)) {
		header('Location: /admin');
		die();
	} else {
		header('Location: ' . URL::addQuery($_GET['return'], ['errors' => $errors]));
		die();
	}

});

$app->get('/admin/hotel-group/delete/:id', function ($id) use ($app) {

	$errors = hotelGroupController::delete($id);
	if(empty($errors)) {
		header('Location: /admin');
		die();
	} else {
		header('Location: ' . URL::addQuery($_GET['return'], ['errors' => $errors]));
		die();
	}

});

$app->get('/admin/hotel/create/:id', function ($id) use ($app) {

	$data = hotelController::create($id);
	if(isset($_GET['errors'])) {
		$data['errors'] = $_GET['errors'];
	}
	return $app->Response('admin/hotel/create.php', array_merge(
		$data,
		['_layout' => 'main.php']
	));

});

$app->post('/admin/hotel/create/:id', function ($id) use ($app) {

	$vars = array_merge($_POST, ['hotel_group_id' => $id]);
	$errors = hotelController::createSubmit($vars);
	if(empty($errors)) {
		header('Location: /admin/hotel-group/' . $id);
		die();
	} else {
		header('Location: ' . URL::addQuery($_GET['return'], ['errors' => $errors]));
		die();
	}

});

$app->get('/admin/hotel/update/:id', function ($id) use ($app) {

	$data = hotelController::update($id);
	if(isset($_GET['errors'])) {
		$data['errors'] = $_GET['errors'];
	}
	return $app->Response('admin/hotel/update.php', array_merge(
		$data,
		['_layout' => 'main.php']
	));

});

$app->post('/admin/hotel/update/:id', function ($id) use ($app) {

	$vars = array_merge($_POST, ['hotel_id' => $id]);
	$data = hotelController::updateSubmit($vars);
	if(empty($errors)) {
		header('Location: /admin/hotel-group/' . $data['group_id']);
		die();
	} else {
		header('Location: ' . URL::addQuery($_GET['return'], ['errors' => $data['errors']]));
		die();
	}

});

$app->get('/admin/hotel/delete/:id', function ($id) use ($app) {

	$errors = hotelController::delete($id);
	if(empty($errors)) {
		header('Location: /admin');
		die();
	} else {
		header('Location: ' . URL::addQuery($_GET['return'], ['errors' => $errors]));
		die();
	}

});

$app->get('/admin/hotel/:id', function ($id) use ($app) {

	$data = hotelController::view($id);
	if(isset($_GET['errors'])) {
		$data['errors'] = $_GET['errors'];
	}
	return $app->Response('admin/room/listing.php', array_merge(
		$data,
		['_layout' => 'main.php']
	));

});


# Launch app
$app->listen();