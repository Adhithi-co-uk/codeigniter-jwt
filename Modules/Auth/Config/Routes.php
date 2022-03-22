<?php

namespace Modules\Auth\Config;

$routes->group('api', ['namespace' => 'Modules\Auth\Controllers'], function ($routes) {
    $routes->post("register", "Register::index");
    $routes->post("login", "Login::index");
    $routes->get("users", "User::index", ['filter' => 'authFilter']);
});
