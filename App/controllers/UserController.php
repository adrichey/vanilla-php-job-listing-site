<?php

namespace App\Controllers;

use App\Models\User;
use App\Repositories\UserRepository;
use Framework\Validation;
use Framework\Session;

class UserController {
    private $userRepo;

    public function __construct() {
        $this->userRepo = new UserRepository();
    }

    public function login(): void {
        loadView('users/login');
    }

    public function authenticate(): void {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $errors = [];

        if (empty($email) || !Validation::email($email)) {
            $errors[] = 'Email must be a valid email address';
        }

        $minPasswordLength = 10;
        if (empty($password) || !Validation::string($password, $minPasswordLength, 255)) {
            $errors[] = "Password must be at least {$minPasswordLength} characters";
        }

        if (!empty($errors)) {
            loadView('users/login', [
                'errors' => $errors,
            ]);
            return;
        }

        $user = $this->userRepo->fetchByEmail($email);

        if (!$user) {
            $errors[] = 'User was not found for this email and password combination';
            loadView('users/login', [
                'errors' => $errors,
            ]);
            return;
        }

        if (!password_verify($password, $user->password)) {
            $errors[] = 'User was not found for this email and password combination';
            loadView('users/login', [
                'errors' => $errors,
            ]);
            return;
        }

        Session::set('user', [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'city' => $user->city,
            'state' => $user->state,
            'zip_code' => $user->zip_code,
        ]);

        redirect('/');
    }

    public function logout(): void {
        Session::clearAll();

        $params = session_get_cookie_params();
        setcookie('PHPSESSID', '', time() - 86400, $params['path'], $params['domain']);

        redirect('/');
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

        $user = $this->userRepo->fetchByEmail($formData['email']);

        if ($user) {
            $errors[] = "This email address is already in use";
            loadView('users/register', [
                'formData' => $formData,
                'errors' => $errors,
            ]);
            return;
        }

        $user = new User($formData);
        $user->password = password_hash($formData['password'], PASSWORD_DEFAULT);
        $this->userRepo->store($user);

        Session::setFlashMessage('success', 'Your account has been created successfully! Please log in below.');

        redirect('/login');
    }
}
