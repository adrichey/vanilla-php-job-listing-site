<?php

require '../helpers.php';
require basePath('Database.php');
require basePath('router.php');

// Instantiate the router
$router = new Router();

// Get the routes
$routes = require basePath('routes.php');

// Get current URI and HTTP method
$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Route the request
$router->route($method, $uri);
