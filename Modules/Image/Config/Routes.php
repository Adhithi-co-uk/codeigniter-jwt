<?php

namespace Modules\Image\Config;

$routes->group('api', ['namespace' => 'Modules\Image\Controllers'], function ($routes) {
    $routes->get('images', 'ImageController::all', ['filter' => 'authFilter']);
    $routes->post('images', 'ImageController::add', ['filter' => 'authFilter']);
    $routes->delete('images/(:num)', 'ImageController::delete/$1', ['filter' => 'authFilter']);
    $routes->get('image/(:num)', 'ImageController::get/$1');
    $routes->get('image/(:segment)', 'ImageController::all/$1', ['filter' => 'authFilter']);
});
