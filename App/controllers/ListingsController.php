<?php

namespace App\Controllers;

use Framework\Database;

class ListingsController {
    private $db;

    public function __construct() {
        $dbConfig = require basePath('config/db.php');
        $this->db = new Database($dbConfig);
    }

    public function index() {
        $listings = $this->db->query('SELECT * FROM listings LIMIT 6')->fetchAll();

        loadView('listings/index', [
            'listings' => $listings,
        ]);
    }

    public function show(array $params) {
        $listing = $this->db
            ->query('SELECT * FROM listings WHERE id = :id LIMIT 1', ['id' => $params['id']])
            ->fetch();

        if (!$listing) {
            ErrorController::notFound();
            return;
        }

        loadView('listings/show', [
            'listing' => $listing,
        ]);
    }

    public function create() {
        loadView('listings/create');
    }
}