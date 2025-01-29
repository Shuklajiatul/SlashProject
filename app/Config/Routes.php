<?php

use App\Controllers\Auth;
use App\Controllers\CdrController;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'AuthController::login');
$routes->get('/', 'Home::index');
$routes->get('/view', 'Home::index'); 
$routes->get('/dashboard', 'Home::index'); 
$routes->get('/users', 'UserController::index');
$routes->get('/chatApp/index', 'ChatController::index');
$routes->get('/campaigns', 'CampaignController::index');
$routes->get('/campaigns/create', 'CampaignController::create');
$routes->post('/campaigns/store', 'CampaignController::store');
$routes->get('/campaigns/edit/(:num)', 'CampaignController::edit/$1');
$routes->post('/campaigns/update/(:num)', 'CampaignController::update/$1');
$routes->post('/campaigns/delete/(:num)', 'CampaignController::delete/$1');
$routes->get('/users/create', 'UserController::create');
$routes->post('/users/store', 'UserController::store');
$routes->get('/users/edit/(:num)', 'UserController::edit/$1');
$routes->post('/users/update/(:num)', 'UserController::update/$1');
$routes->post('/users/delete/(:num)', 'UserController::delete/$1');
$routes->post('/campaigns/filter', 'CampaignController::filter'); 
$routes->post('/users/filter', 'UserController::filter'); 
$routes->get('/reports/cdr', 'CdrController::index');
$routes->get('/reports/cdr/download', 'CdrController::downloadCDRCSV');
$routes->get('/reports/cdr/filter', 'CdrController::filter');
$routes->get('/reports/summary', 'CdrController::summary');
$routes->get('/reports/summary/download', 'CdrController::downloadSummaryCSV');

$routes->get('/login', 'AuthController::login');
$routes->post('/login', 'AuthController::login');
$routes->get('/register', 'AuthController::register');
$routes->post('/register', 'AuthController::register');
$routes->get('/logout', 'AuthController::logout');

?>

