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
use \controllers\roomController as roomController;
use \controllers\employeeController as employeeController;

# Models
use \models\Config as Config;
use \models\URL as URL;

# Seeders
use \seeders\EmployeeSeeder as EmployeeSeeder;

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
		$url = $_GET['success'];
	} else {
		$url = URL::addQuery($_GET['error'], ['errors' => $errors]);
	}
	$app->Redirect($url);

});

$app->get('/admin/hotel-group/:hotel_group_id', function ($hotel_group_id) use ($app) {

	$data = hotelGroupController::view($hotel_group_id);
	if(isset($_GET['errors'])) {
		$data['errors'] = $_GET['errors'];
	}
	return $app->Response('admin/hotel-group/view.php', array_merge(
		$data,
		['_layout' => 'main.php']
	));

});

$app->get('/admin/hotel-group/update/:hotel_group_id', function ($hotel_group_id) use ($app) {

	$data = hotelGroupController::update($hotel_group_id);
	if(isset($_GET['errors'])) {
		$data['errors'] = $_GET['errors'];
	}
	return $app->Response('admin/hotel-group/update.php', array_merge(
		$data,
		['_layout' => 'main.php']
	));

});

$app->post('/admin/hotel-group/update/:hotel_group_id', function ($hotel_group_id) use ($app) {

	$vars = array_merge($_POST, ['hotel_group_id' => $hotel_group_id]);
	$errors = hotelGroupController::updateSubmit($vars);
	if(empty($errors)) {
		$url = $_GET['success'];
	} else {
		$url = URL::addQuery($_GET['error'], ['errors' => $errors]);
	}
	$app->Redirect($url);

});

$app->get('/admin/hotel-group/delete/:hotel_group_id', function ($hotel_group_id) use ($app) {

	$errors = hotelGroupController::delete($hotel_group_id);
	if(empty($errors)) {
		$url = $_GET['success'];
	} else {
		$url = URL::addQuery($_GET['error'], ['errors' => $errors]);
	}
	$app->Redirect($url);

});

$app->get('/admin/hotel/create/:hotel_group_id', function ($hotel_group_id) use ($app) {

	$data = hotelController::create($hotel_group_id);
	if(isset($_GET['errors'])) {
		$data['errors'] = $_GET['errors'];
	}
	return $app->Response('admin/hotel/create.php', array_merge(
		$data,
		['_layout' => 'main.php']
	));

});

$app->post('/admin/hotel/create/:hotel_group_id', function ($hotel_group_id) use ($app) {

	$vars = array_merge($_POST, ['hotel_group_id' => $hotel_group_id]);
	$errors = hotelController::createSubmit($vars);
	if(empty($errors)) {
		$url = $_GET['success'];
	} else {
		$url = URL::addQuery($_GET['error'], ['errors' => $errors]);
	}
	$app->Redirect($url);

});

$app->get('/admin/hotel/update/:hotel_id', function ($hotel_id) use ($app) {

	$data = hotelController::update($hotel_id);
	if(isset($_GET['errors'])) {
		$data['errors'] = $_GET['errors'];
	}
	return $app->Response('admin/hotel/update.php', array_merge(
		$data,
		['_layout' => 'main.php']
	));

});

$app->post('/admin/hotel/update/:hotel_id', function ($hotel_id) use ($app) {

	$vars = array_merge($_POST, ['hotel_id' => $hotel_id]);
	$errors = hotelController::updateSubmit($vars);
	if(empty($errors)) {
		$url = $_GET['success'];
	} else {
		$url = URL::addQuery($_GET['error'], ['errors' => $errors]);
	}
	$app->Redirect($url);

});

$app->get('/admin/hotel/delete/:hotel_id', function ($hotel_id) use ($app) {

	$errors = hotelController::delete($hotel_id);
	if(empty($errors)) {
		$url = $_GET['success'];
	} else {
		$url = URL::addQuery($_GET['error'], ['errors' => $errors]);
	}
	$app->Redirect($url);

});

$app->get('/admin/hotel/:hotel_id', function ($hotel_id) use ($app) {

	$data = hotelController::view($hotel_id);
	if(isset($_GET['errors'])) {
		$data['errors'] = $_GET['errors'];
	}
	return $app->Response('admin/hotel/view.php', array_merge(
		$data,
		['_layout' => 'main.php']
	));

});

$app->get('/admin/room/create/:hotel_id', function ($hotel_id) use ($app) {

	$data = roomController::create($hotel_id);
	if(isset($_GET['errors'])) {
		$data['errors'] = $_GET['errors'];
	}
	return $app->Response('admin/room/create.php', array_merge(
		$data,
		['_layout' => 'main.php']
	));

});

$app->post('/admin/room/create/:hotel_id', function ($hotel_id) use ($app) {

	$vars = array_merge($_POST, ['hotel_id' => $hotel_id]);
	$errors = roomController::createSubmit($vars);
	if(empty($errors)) {
		$url = $_GET['success'];
	} else {
		$url = URL::addQuery($_GET['error'], ['errors' => $errors]);
	}
	$app->Redirect($url);

});

$app->get('/admin/room/update/:room_id', function ($room_id) use ($app) {

	$data = roomController::update($room_id);
	if(isset($_GET['errors'])) {
		$data['errors'] = $_GET['errors'];
	}
	return $app->Response('admin/room/update.php', array_merge(
		$data,
		['_layout' => 'main.php']
	));

});

$app->post('/admin/room/update/:room_id', function ($room_id) use ($app) {

	$vars = array_merge($_POST, ['room_id' => $room_id]);
	$errors = roomController::updateSubmit($vars);
	if(empty($errors)) {
		$url = $_GET['success'];
	} else {
		$url = URL::addQuery($_GET['error'], ['errors' => $errors]);
	}
	$app->Redirect($url);

});

$app->get('/admin/room/delete/:room_id', function ($room_id) use ($app) {

	$errors = roomController::delete($room_id);
	if(empty($errors)) {
		$url = $_GET['success'];
	} else {
		$url = URL::addQuery($_GET['error'], ['errors' => $errors]);
	}
	$app->Redirect($url);

});

$app->get('/admin/employee/create', function () use ($app) {
	
	$data = employeeController::create();
	if(isset($_GET['errors'])) {
		$data['errors'] = $_GET['errors'];
	}

	return $app->Response('admin/employee/create.php', array_merge(
		$data,
		['_layout' => 'main.php']
	));

});

$app->post('/admin/employee/create', function () use ($app) {

	$errors = employeeController::createSubmit($_POST);
	if(empty($errors)) {
		$url = $_GET['success'];
	} else {
		$url = URL::addQuery($_GET['error'], ['errors' => $errors]);
	}
	$app->Redirect($url);
});

$app->get('/admin/employee/create/:hotel_id', function ($hotel_id) use ($app) {
	
	$data = employeeController::create($hotel_id);
	if(isset($_GET['errors'])) {
		$data['errors'] = $_GET['errors'];
	}

	return $app->Response('admin/employee/create.php', array_merge(
		$data,
		['_layout' => 'main.php']
	));

});

$app->post('/admin/employee/create/:hotel_id', function ($hotel_id) use ($app) {

	$vars = array_merge($_POST, ['hotel_id' => $hotel_id]);
	$errors = employeeController::createSubmit($vars);
	if(empty($errors)) {
		$url = $_GET['success'];
	} else {
		$url = URL::addQuery($_GET['error'], ['errors' => $errors]);
	}
	$app->Redirect($url);
});

$app->get('/admin/employee/:irs', function ($irs) use ($app) {

	$data = employeeController::view($irs);
	if(isset($_GET['errors'])) {
		$data['errors'] = $_GET['errors'];
	}
	return $app->Response('admin/employee/view.php', array_merge(
		$data,
		['_layout' => 'main.php']
	));

});

$app->get('/admin/employee/update/:irs', function ($irs) use ($app) {

	$data = employeeController::update($irs);
	if(isset($_GET['errors'])) {
		$data['errors'] = $_GET['errors'];
	}
	return $app->Response('admin/employee/update.php', array_merge(
		$data,
		['_layout' => 'main.php']
	));

});

$app->post('/admin/employee/update/:irs', function ($irs) use ($app) {

	$vars = array_merge($_POST, ['emp_IRS' => $irs]);
	$errors = employeeController::updateSubmit($vars);
	if(empty($errors)) {
		$url = $_GET['success'];
	} else {
		$url = URL::addQuery($_GET['error'], ['errors' => $errors]);
	}
	$app->Redirect($url);

});

$app->get('/admin/employee/delete/:irs', function ($irs) use ($app) {

	$errors = employeeController::delete($irs);
	if(empty($errors)) {
		$url = $_GET['success'];
	} else {
		$url = URL::addQuery($_GET['error'], ['errors' => $errors]);
	}
	$app->Redirect($url);

});


$app->get('/seed/employees/:num', function ($num) use ($app) {
	EmployeeSeeder::run($num, isset($_GET['onlySQL']));
});


# Launch app
$app->listen();