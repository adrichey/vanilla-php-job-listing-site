<?php

use Framework\Database;

$dbConfig = require basePath('config/db.php');
$db = new Database($dbConfig);

$listingId = $_GET['id'] ?? '';

$listing = $db->query('SELECT * FROM listings WHERE id = :id LIMIT 1', ['id' => $listingId])->fetch();

loadView('listings/show', [
    'listing' => $listing,
]);
