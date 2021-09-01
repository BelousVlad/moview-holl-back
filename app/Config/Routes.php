<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.

$routes->get('xml/parse_ua_movies', 'XML::parse_ua_movies');
$routes->get('xml', 'XML::gen_database');
$routes->post('api/add_slide', 'Api::add_slide');
$routes->get('api/get_slides', 'Api::get_slides');
// $routes->get('api/get_max/(:alpha)', 'Api::get_max/$1');
$routes->get('api/get_max', 'Api::get_max');
$routes->group('{locale}', ['filter' => 'i18n'] ,function($routes) {
	$routes->get('api/movies/(:num)', 'Api::movie/$1');
	$routes->get('api/movies', 'Api::movie');
	$routes->get('api/categories', 'Api::categories');
	$routes->get('api/genres/(:alpha)/(:segment)', 'Api::genres/$2/$1');
	$routes->get('api/genres/(:num)', 'Api::genres/$1');
	$routes->get('api/genres', 'Api::genres');
	$routes->get('api', 'Api::movies');
});
$routes->post('slider/login', 'Login::login');
$routes->get('slider/is_login', 'Login::isLogin');
$routes->get('.*', 'Home::index');

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *	
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
