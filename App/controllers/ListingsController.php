<?php

namespace App\Controllers;

use Framework\Database;
use Framework\Validation;

class ListingsController {
    private $db;
    private $allowedFields;

    public function __construct() {
        $dbConfig = require basePath('config/db.php');
        $this->db = new Database($dbConfig);

        // TODO: Might be good to put this into the Listings model once created
        $this->allowedFields = [
            'title',
            'description',
            'salary',
            'salary_frequency',
            'requirements',
            'benefits',
            'company',
            'address',
            'city',
            'state',
            'zip_code',
            'phone',
            'email',
        ];
    }

    public function index(): void {
        $listings = $this->db->query('SELECT * FROM listings LIMIT 6')->fetchAll();

        loadView('listings/index', [
            'listings' => $listings,
        ]);
    }

    public function show(array $params): void {
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

    public function create(array $params = []): void {
        // Default the form values if they are not present (i.e. submitted via a form)
        $listing = [];
        foreach ($this->allowedFields as $field) {
            $listing[$field] = $params['listing'][$field] ?? '';
        }

        loadView('listings/create', [
            'errors' => $params['errors'] ?? [],
            'listing' => $listing,
        ]);
    }

    public function store(): void {
        $listingData = array_intersect_key($_POST, array_flip($this->allowedFields));

        // TODO: Get this from logged in user session details once implemented
        $listingData['user_id'] = 1;

        $listingData = array_map('sanitize', $listingData);

        $requiredFields = [
            'title',
            'description',
            'city',
            'state',
            'zip_code',
            'email',
        ];

        $errors = [];
        foreach ($requiredFields as $field) {
            if (empty($listingData[$field]) || !Validation::string($listingData[$field])) {
                $errors[] = $field;
            }
        }

        if (!empty($errors)) {
            $this->create([
                'errors' => $errors,
                'listing' => $listingData,
            ]);
            return;
        }

        // TODO: Replace this with save logic
        $this->index();
    }
}