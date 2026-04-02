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
        $formData = [
            'name' => '',
            'email' => '',
            'city' => '',
            'state' => '',
            'zip_code' => '',
            'password' => '',
            'password_confirmation' => '',
        ];

        loadView('users/register', [
            'formData' => $formData,
        ]);
    }

    public function store(): void {
        $formData = [
            'name' => $_POST['name'] ?? '',
            'email' => $_POST['email'] ?? '',
            'city' => $_POST['city'] ?? '',
            'state' => $_POST['state'] ?? '',
            'zip_code' => $_POST['zip_code'] ?? '',
            'password' => $_POST['password'] ?? '',
            'password_confirmation' => $_POST['password_confirmation'] ?? '',
        ];

        $errors = [];
        if (empty($formData['name']) || !Validation::string($formData['name'], 2, 255)) {
            $errors[] = "Full Name cannot be blank";
        }

        if (empty($formData['email']) || !Validation::email($formData['email'])) {
            $errors[] = "Email must contain a valid email address";
        }

        if (empty($formData['city']) || !Validation::string($formData['city'], 2, 255)) {
            $errors[] = "City cannot be blank";
        }

        if (empty($formData['state']) || !Validation::string($formData['state'], 2, 255)) {
            $errors[] = "State cannot be blank";
        }

        if (empty($formData['zip_code']) || !Validation::string($formData['zip_code'], 2, 45)) {
            $errors[] = "ZIP Code cannot be blank";
        }

        $minPasswordLength = 10;
        if (empty($formData['password']) || !Validation::string($formData['password'], $minPasswordLength, 255)) {
            $errors[] = "Password must be at least {$minPasswordLength} characters";
        }

        if ($formData['password'] !== $formData['password_confirmation']) {
            $errors[] = "Password and confirmation are not a match";
        }

        if (!empty($errors)) {
            $formData['password'] = '';
            $formData['password_confirmation'] = '';

            loadView('users/register', [
                'formData' => $formData,
                'errors' => $errors,
            ]);
            return;
        }

        $user = $this->db
            ->query('SELECT * FROM users WHERE email = :email LIMIT 1', ['email' => $formData['email']])
            ->fetch();

        if ($user) {
            $errors[] = "This email address is already in use";
            loadView('users/register', [
                'formData' => $formData,
                'errors' => $errors,
            ]);
            return;
        }

        unset($formData['password_confirmation']);

        // Prepare query fields to persist listing to DB
        $fields = implode(',', array_keys($formData));
        $values = ':' . implode(',:', array_keys($formData));
        $query = "INSERT INTO users ({$fields}) VALUES ({$values})";

        // Default empty values to null for query
        foreach ($formData as $key => $value) {
            if ($value === '') {
                $formData[$key] = null;
            }
        }

        $this->db->query($query, $formData);

        $_SESSION['success_message'] = 'Your account has been created successfully! Please log in below.';

        redirect('/login');
    }
}
