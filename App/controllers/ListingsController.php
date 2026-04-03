<?php

namespace App\Controllers;

use App\Models\Listing;
use App\Repositories\ListingRepository;
use Framework\Validation;
use Framework\Session;

class ListingsController {
    private $listingRepo;

    public function __construct() {
        $this->listingRepo = new ListingRepository();
    }

    public function index(): void {
        $listings = $this->listingRepo->fetchAll();

        loadView('listings/index', [
            'listings' => $listings,
        ]);
    }

    public function show(array $params): void {
        $listing = $this->listingRepo->fetch((int) $params['id']);

        if (!$listing) {
            ErrorController::notFound();
            return;
        }

        loadView('listings/show', [
            'listing' => $listing,
        ]);
    }

    public function create(array $params = []): void {
        $listing = new Listing();
        if (isset($params['listing']) && !empty($params['listing'])) {
            $listing->merge($params['listing']);
        }

        loadView('listings/create', [
            'errors' => $params['errors'] ?? [],
            'listing' => $listing,
        ]);
    }

    public function store(): void {
        $listingData = array_merge($_POST, [
            'user_id' => Session::get('user')['id'],
            'salary' => isset($_POST['salary']) ? intval(floatval($_POST['salary']) * 100) : 0,
        ]);
        $listingData = array_map('sanitize', $listingData);

        $errors = $this->validateListingData($listingData);

        $listing = new Listing($listingData);

        if (!empty($errors)) {
            $this->create([
                'errors' => $errors,
                'listing' => $listing,
            ]);
            return;
        }

        $listingId = $this->listingRepo->store($listing);

        Session::setFlashMessage('success', 'Listing created successfully');

        redirect("/listings/{$listingId}");
    }

    public function edit(array $params = []): void {
        $id = (int) $params['id'];
        $listing = $this->listingRepo->fetch($id);

        if (!$listing) {
            ErrorController::notFound();
            return;
        }

        if (Session::get('user')['id'] !== $listing->user_id) {
            Session::setFlashMessage('error', 'You do not have permission to edit this listing');
            redirect("/listings/{$listing->id}");
        }

        if (isset($params['listing']) && !empty($params['listing'])) {
            $listing->merge($params['listing']);
        }

        loadView('listings/edit', [
            'id' => $id,
            'errors' => $params['errors'] ?? [],
            'listing' => $listing,
        ]);
    }

    public function update(array $params): void {
        $id = (int) $params['id'];
        $listing = $this->listingRepo->fetch($id);

        if (!$listing) {
            ErrorController::notFound();
            return;
        }

        if (Session::get('user')['id'] !== $listing->user_id) {
            Session::setFlashMessage('error', 'You do not have permission to edit this listing');
            redirect("/listings/{$listing->id}");
        }

        $listingData = array_merge($_POST, [
            'user_id' => Session::get('user')['id'],
            'salary' => isset($_POST['salary']) ? intval($_POST['salary'] * 100) : 0,
        ]);

        $listingData = array_map('sanitize', $listingData);

        $errors = $this->validateListingData($listingData);

        $listing->merge(new Listing($listingData));

        if (!empty($errors)) {
            $this->edit([
                'id' => $id,
                'errors' => $errors,
                'listing' => $listing,
            ]);
            return;
        }

        $this->listingRepo->update($listing);

        Session::setFlashMessage('success', 'Listing updated successfully');

        redirect("/listings/{$listing->id}");
    }

    public function destroy(array $params): void {
        $listing = $this->listingRepo->fetch((int) $params['id']);

        if (!$listing) {
            ErrorController::notFound();
            return;
        }

        if (Session::get('user')['id'] !== $listing->user_id) {
            Session::setFlashMessage('error', 'You do not have permission to delete this listing');
            redirect("/listings/{$listing->id}");
        }

        $this->listingRepo->destroy($listing);

        Session::setFlashMessage('success', 'Listing deleted successfully');

        redirect('/listings');
    }

    public function search(): void {
        $keywords = isset($_GET['keywords']) ? trim($_GET['keywords']) : '';
        $location = isset($_GET['location']) ? trim($_GET['location']) : '';

        $listings = $this->listingRepo->search($keywords, $location);

        loadView('/listings/index', [
            'listings' => $listings,
            'keywords' => htmlspecialchars(sanitize($keywords)),
            'location' => htmlspecialchars(sanitize($location)),
        ]);
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