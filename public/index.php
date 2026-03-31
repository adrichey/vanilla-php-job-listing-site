<?php

require '../helpers.php';

spl_autoload_register(function (string $class) {
    $path = basePath("Framework/{$class}.php");

    if (file_exists($path)) {
        require $path;
    }
});

// Instantiate the router
$router = new Router();

// Get the routes
$routes = require basePath('routes.php');

// Get current URI and HTTP method
$method = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Route the request
$router->route($method, $uri);
