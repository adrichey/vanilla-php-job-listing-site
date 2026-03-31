<?php

require '../helpers.php';
require basePath('Database.php');
require basePath('router.php');

$dbConfig = require basePath('config/db.php');
$db = new Database($dbConfig);

$router = new Router();

$routes = require basePath('routes.php');

$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

$router->route($method, $uri);
