<?php

namespace App\Controllers;

use Framework\Database;
use Framework\Validation;
use Framework\Session;

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
            'tags',
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
        $listings = $this->db->query('SELECT * FROM listings ORDER BY created_at DESC')->fetchAll();

        loadView('listings/index', [
            'listings' => $listings,
        ]);
    }

    public function show(array $params): void {
        $listing = $this->db
            ->query('SELECT * FROM listings WHERE id = :id LIMIT 1', ['id' => $params['id'] ?? ''])
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
        $listingData['user_id'] = Session::get('user')['id'];

        $listingData = array_map('sanitize', $listingData);

        $errors = $this->validateListingData($listingData);

        if (!empty($errors)) {
            $this->create([
                'errors' => $errors,
                'listing' => $listingData,
            ]);
            return;
        }

        // Prepare query fields to persist listing to DB
        $fields = implode(',', array_keys($listingData));
        $values = ':' . implode(',:', array_keys($listingData));
        $query = "INSERT INTO listings ({$fields}) VALUES ({$values})";

        // Default empty values to null for query
        foreach ($listingData as $key => $value) {
            if ($value === '') {
                $listingData[$key] = null;
            }
        }

        // Salary is stored in cents, so we need to normalize input
        if ($listingData['salary'] !== null) {
            $listingData['salary'] = convertCurrencyToCents(floatval($listingData['salary']));
        }

        $this->db->query($query, $listingData);

        $listingId = $this->db->conn->lastInsertId();

        Session::setFlashMessage('success', 'Listing created successfully');

        redirect("/listings/{$listingId}");
    }

    public function edit(array $params = []): void {
        $listing = $this->db
            ->query('SELECT * FROM listings WHERE id = :id LIMIT 1', ['id' => $params['id'] ?? ''])
            ->fetch();

        if (!$listing) {
            ErrorController::notFound();
            return;
        }

        // TODO: Refactor into model public method Listing->isOwner(int $userId)
        if (Session::get('user')['id'] !== $listing->user_id) {
            Session::setFlashMessage('error', 'You do not have permission to edit this listing');
            redirect("/listings/{$listing->id}");
        }

        // Default the form values if they are not present (i.e. submitted via a form)
        $listingData = [];
        foreach ($this->allowedFields as $field) {
            $listingData[$field] = $params['listing'][$field] ?? $listing->$field;
        }

        $listingData['id'] = $listing->id;
        $listingData['salary'] = convertCentsToDollars($listingData['salary']);

        loadView('listings/edit', [
            'errors' => $params['errors'] ?? [],
            'labels' => $this->allowedFields,
            'listing' => $listingData,
        ]);
    }

    public function update(array $params): void {
        $listing = $this->db
            ->query('SELECT * FROM listings WHERE id = :id LIMIT 1', ['id' => $params['id'] ?? ''])
            ->fetch();

        if (!$listing) {
            ErrorController::notFound();
            return;
        }

        $listingData = array_intersect_key($_POST, array_flip($this->allowedFields));

        $listingData = array_map('sanitize', $listingData);

        $errors = $this->validateListingData($listingData);

        if (!empty($errors)) {
            $this->edit([
                'errors' => $errors,
                'listing' => $listingData,
            ]);
            return;
        }

        // Prepare query fields to persist listing to DB
        $fields = [];
        foreach ($this->allowedFields as $field) {
            $fields[] = "{$field} = :{$field}";
        }
        $fields = implode(', ', $fields);

        $query = "UPDATE listings SET {$fields} WHERE id = :id";

        // Default empty values to null for query
        foreach ($listingData as $key => $value) {
            if ($value === '') {
                $listingData[$key] = null;
            }
        }

        // Salary is stored in cents, so we need to normalize input
        if ($listingData['salary'] !== null) {
            $listingData['salary'] = convertCurrencyToCents(floatval($listingData['salary']));
        }

        // TODO: Refactor into model public method Listing->isOwner(int $userId)
        if (Session::get('user')['id'] !== $listing->user_id) {
            Session::setFlashMessage('error', 'You do not have permission to edit this listing');
            redirect("/listings/{$listing->id}");
        }

        $listingData['id'] = $listing->id;
        $this->db->query($query, $listingData);

        Session::setFlashMessage('success', 'Listing updated successfully');

        redirect("/listings/{$listing->id}");
    }

    public function destroy(array $params): void {
        $listing = $this->db
            ->query('SELECT * FROM listings WHERE id = :id LIMIT 1', ['id' => $params['id'] ?? ''])
            ->fetch();

        if (!$listing) {
            ErrorController::notFound();
            return;
        }

        // TODO: Refactor into model public method Listing->isOwner(int $userId)
        if (Session::get('user')['id'] !== $listing->user_id) {
            Session::setFlashMessage('error', 'You do not have permission to delete this listing');
            redirect("/listings/{$listing->id}");
        }

        $this->db->query('DELETE FROM listings WHERE id = :id', [
            'id' => $listing->id
        ]);

        Session::setFlashMessage('success', 'Listing deleted successfully');

        redirect('/listings');
    }

    private function validateListingData(array $listingData): array {
        $errors = [];
        if (empty($listingData['title']) || !Validation::string($listingData['title'], 2, 255)) {
            $errors[] = "Job Title cannot be blank";
        }

        if (empty($listingData['description']) || !Validation::string($listingData['description'])) {
            $errors[] = "Job Description cannot be blank";
        }

        if (empty($listingData['salary']) || !Validation::string($listingData['salary']) || !is_numeric($listingData['salary'])) {
            $errors[] = "Salary is required and must contain only numbers and decimal points";
        }

        $validFrequencies = [
            'annually',
            'monthly',
            'bi_weekly',
            'weekly',
            'hourly',
            'per_project',
        ];

        if (empty($listingData['salary_frequency']) || !in_array($listingData['salary_frequency'], $validFrequencies)) {
            $errors[] = "Salary Frequency is required";
        }

        if (empty($listingData['city']) || !Validation::string($listingData['city'], 2, 255)) {
            $errors[] = "City cannot be blank";
        }

        if (empty($listingData['state']) || !Validation::string($listingData['state'], 2, 255)) {
            $errors[] = "State cannot be blank";
        }

        if (empty($listingData['zip_code']) || !Validation::string($listingData['zip_code'], 2, 45)) {
            $errors[] = "ZIP Code cannot be blank";
        }

        if (empty($listingData['email']) || !Validation::string($listingData['email'])) {
            $errors[] = "Email Address For Applications must be a valid email address";
        }

        return $errors;
    }
}