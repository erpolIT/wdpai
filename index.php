<?php

require_once __DIR__ . '/Application.php';


$app = new Application(dirname(__DIR__));


$app->router->get('/', ['DashboardController', 'dashboard']);
$app->router->get('/dashboard', ['DashboardController', 'dashboard']);
$app->router->get('/project', 'DashboardController');
$app->router->post('/project', 'DashboardController');

$app->router->get('/login', ['SecurityController', 'login']);
$app->router->post('/login', ['SecurityController', 'login']);
$app->router->post('/logout', ['SecurityController', 'logout']);


$app->router->post('/register', ['SecurityController', 'register']);
$app->router->get('/register', ['SecurityController', 'register']);

$app->router->get('/reservations', ['ReservationController', 'getReservations']);

$app->router->post('/addProject', 'ProjectController');
$app->router->get('/apartments', ['ApartmentController', 'index']);
$app->router->get('/searchApartment', ['ApartmentController', 'searchApartment']);
$app->router->post('/addReservation', ['ReservationController', 'addReservation']);
$app->router->get('/profile', ['ProfileController', 'index']);

$app->router->post('/apartments/create', ['ApartmentController', 'create']);

$app->router->post('/profile/update', ['ProfileController', 'updateProfile']);


$app->run();