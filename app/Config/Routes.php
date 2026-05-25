<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Menampilkan Landing Page
$routes->get('/', 'HomeController::index');

// Menampilkan Halaman Login
$routes->get('login', 'AuthController::index');