<?php

$dbConfig = require basePath('config/db.php');
$db = new Database($dbConfig);

$listings = $db->query('SELECT * FROM listings LIMIT 6')->fetchAll();

loadView('home', [
    'listings' => $listings,
]);
