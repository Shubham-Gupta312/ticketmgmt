<?php

namespace Config;

$routes = Services::routes();

$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
// $routes->setDefaultController('Superadmin');
// $routes->setDefaultMethod('login');
$routes->setAutoRoute(true);