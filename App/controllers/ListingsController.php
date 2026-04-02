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
            'title' => 'Job Title',
            'description' => 'Job Description',
            'salary' => 'Salary',
            'salary_frequency' => 'Salary Frequency',
            'requirements' => 'Requirements',
            'benefits' => 'Benefits',
            'company' => 'Company Name',
            'address' => 'Address',
            'city' => 'City',
            'state' => 'State',
            'zip_code' => 'ZIP Code',
            'phone' => 'Phone',
            'email' => 'Email Address For Applications',
        ];
    }

    public function index(): void {
        $listings = $this->db->query('SELECT * FROM listings')->fetchAll();

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
        $allowedFieldsKeys = array_keys($this->allowedFields);

        // Default the form values if they are not present (i.e. submitted via a form)
        $listing = [];
        foreach ($allowedFieldsKeys as $field) {
            $listing[$field] = $params['listing'][$field] ?? '';
        }

        loadView('listings/create', [
            'errors' => $params['errors'] ?? [],
            'labels' => $this->allowedFields,
            'listing' => $listing,
        ]);
    }

    public function store(): void {
        $listingData = array_intersect_key($_POST, $this->allowedFields);

        // TODO: Get this from logged in user session details once implemented
        $listingData['user_id'] = 1;

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

        redirect('/listings');
    }

    public function edit(array $params = []): void {
        $existingListing = $this->db
            ->query('SELECT * FROM listings WHERE id = :id LIMIT 1', ['id' => $params['id'] ?? ''])
            ->fetch();

        if (!$existingListing) {
            ErrorController::notFound();
            return;
        }

        $allowedFieldsKeys = array_keys($this->allowedFields);

        // Default the form values if they are not present (i.e. submitted via a form)
        $listingData = [];
        foreach ($allowedFieldsKeys as $field) {
            $listingData[$field] = $params['listing'][$field] ?? $existingListing->$field;
        }

        $listingData['id'] = $existingListing->id;
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

        $listingData = array_intersect_key($_POST, $this->allowedFields);

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
        $fieldKeys = array_keys($this->allowedFields);
        foreach ($fieldKeys as $field) {
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

        $listingData['id'] = $listing->id;
        $this->db->query($query, $listingData);

        // TODO: Refactor into session class later on
        // Set flash message
        $_SESSION['success_message'] = 'Listing updated successfully';

        redirect("/listings/{$listing->id}");
    }

    public function destroy(array $params): void {
        $listingId = $params['id'];

        $listing = $this->db
            ->query('SELECT * FROM listings WHERE id = :id LIMIT 1', ['id' => $listingId])
            ->fetch();

        if (!$listing) {
            ErrorController::notFound();
            return;
        }

        // TODO: Only allow user that created listing to delete it once we implement user system
        $this->db->query('DELETE FROM listings WHERE id = :id', [
            'id' => $listing->id
        ]);

        // TODO: Refactor into session class later on
        // Set flash message
        $_SESSION['success_message'] = 'Listing deleted successfully';

        redirect('/listings');
    }

    private function validateListingData(array $listingData): array {
        $requiredFields = [
            'title',
            'description',
            'salary',
            'salary_frequency',
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

        return $errors;
    }
}