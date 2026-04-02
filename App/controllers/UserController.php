<?php

namespace App\Controllers;

use Framework\Database;
use Framework\Validation;

class UserController {
    private $db;

    public function __construct() {
        $dbConfig = require basePath('config/db.php');
        $this->db = new Database($dbConfig);
    }

    public function login(): void {
        loadView('users/login');
    }

    public function authenticate(): void {
        // TODO: Get stuff from POST and authenticate user
        inspect($_POST, true);
    }

    public function register(): void {
        loadView('users/register');
    }

    public function store(): void {
        // TODO: Get stuff from POST and store it
        inspect($_POST, true);
    }
}
