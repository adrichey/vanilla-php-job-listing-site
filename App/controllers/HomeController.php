<?php

namespace App\Controllers;

use Framework\Database;

class HomeController {
    private $db;

    public function __construct() {
        $dbConfig = require basePath('config/db.php');
        $this->db = new Database($dbConfig);
    }

    public function index(): void {
        $listings = $this->db->query('SELECT * FROM listings ORDER BY created_at DESC LIMIT 6')->fetchAll();

        loadView('home', [
            'listings' => $listings,
        ]);
    }
}
