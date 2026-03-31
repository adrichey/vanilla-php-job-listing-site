<?php

require '../helpers.php';
require basePath('router.php');

$router = new Router();

$routes = require basePath('routes.php');

$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

$router->route($method, $uri);
