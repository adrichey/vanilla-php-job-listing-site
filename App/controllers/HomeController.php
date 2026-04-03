<?php

namespace App\Controllers;

use App\Repositories\ListingRepository;

class HomeController {
    private $listingRepo;

    public function __construct() {
        $this->listingRepo = new ListingRepository();
    }

    public function index(): void {
        $listings = $this->listingRepo->fetchAll();

        loadView('home', [
            'listings' => $listings,
        ]);
    }
}
