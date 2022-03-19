<?php

namespace Modules\Image\Config;

$routes->group('api', ['namespace' => 'Modules\Image\Controllers'], function ($routes) {
    $routes->get('images', 'ImageController::all');
    $routes->post('images', 'ImageController::add');
    $routes->delete('images/(:num)', 'ImageController::delete/$1');
    $routes->get('image/(:num)', 'ImageController::get/$1');
    $routes->get('image/(:segment)', 'ImageController::all/$1');
});
