<?php

namespace App\Models;

use NumberFormatter;

class Listing {
    public int $id = 0;
    public int $user_id = 0;
    public string $title = '';
    public string $description = '';
    public string $tags = '';
    public int $salary = 0;
    public string $salary_frequency = '';
    public string $requirements = '';
    public string $benefits = '';
    public string $company = '';
    public string $address = '';
    public string $city = '';
    public string $state = '';
    public string $zip_code = '';
    public string $phone = '';
    public string $email = '';
    public string $created_at = '';
    public string $updated_at = '';

    public function __construct(array $listingData = []) {
        if (!empty($listingData)) {
            $this->id = isset($listingData['id']) ? intval($listingData['id']) : 0;
            $this->user_id = isset($listingData['user_id']) ? intval($listingData['user_id']) : 0;
            $this->title = isset($listingData['title']) ? (string) $listingData['title'] : '';
            $this->description = isset($listingData['description']) ? (string) $listingData['description'] : '';
            $this->tags = isset($listingData['tags']) ? (string) $listingData['tags'] : '';
            $this->salary = isset($listingData['salary']) ? intval($listingData['salary']) : 0;
            $this->salary_frequency = isset($listingData['salary_frequency']) ? (string) $listingData['salary_frequency'] : '';
            $this->requirements = isset($listingData['requirements']) ? (string) $listingData['requirements'] : '';
            $this->benefits = isset($listingData['benefits']) ? (string) $listingData['benefits'] : '';
            $this->company = isset($listingData['company']) ? (string) $listingData['company'] : '';
            $this->address = isset($listingData['address']) ? (string) $listingData['address'] : '';
            $this->city = isset($listingData['city']) ? (string) $listingData['city'] : '';
            $this->state = isset($listingData['state']) ? (string) $listingData['state'] : '';
            $this->zip_code = isset($listingData['zip_code']) ? (string) $listingData['zip_code'] : '';
            $this->phone = isset($listingData['phone']) ? (string) $listingData['phone'] : '';
            $this->email = isset($listingData['email']) ? (string) $listingData['email'] : '';
            return;
        }
    }

    public function merge(Listing $listing): void {
        $this->id = !empty($listing->id) ? $listing->id : $this->id;
        $this->user_id = !empty($listing->user_id) ? $listing->id : $this->id;
        $this->title = !empty($listing->title) ? $listing->title : $this->title;
        $this->description = !empty($listing->description) ? $listing->description : $this->description;
        $this->tags = !empty($listing->tags) ? $listing->tags : $this->tags;
        $this->salary = !empty($listing->salary) ? $listing->salary : $this->salary;
        $this->salary_frequency = !empty($listing->salary_frequency) ? $listing->salary_frequency : $this->salary_frequency;
        $this->requirements = !empty($listing->requirements) ? $listing->requirements : $this->requirements;
        $this->benefits = !empty($listing->benefits) ? $listing->benefits : $this->benefits;
        $this->company = !empty($listing->company) ? $listing->company : $this->company;
        $this->address = !empty($listing->address) ? $listing->address : $this->address;
        $this->city = !empty($listing->city) ? $listing->city : $this->city;
        $this->state = !empty($listing->state) ? $listing->state : $this->state;
        $this->zip_code = !empty($listing->zip_code) ? $listing->zip_code : $this->zip_code;
        $this->phone = !empty($listing->phone) ? $listing->phone : $this->phone;
        $this->email = !empty($listing->email) ? $listing->email : $this->email;
    }

    public function formattedSalary(): string {
        $amount = $this->salary / 100;
        $formatter = new NumberFormatter('en_US', NumberFormatter::CURRENCY);

        $formattedAmount = $formatter->formatCurrency($amount, 'USD');

        if ($formattedAmount === false) {
            return "{$amount}";
        }

        if (str_ends_with($formattedAmount, '.00')) {
            return substr($formattedAmount, 0, -3);
        }

        return $formattedAmount;
    }

    public function salaryInCents(): int {
        return intval(round($this->salary * 100, 0));
    }

    public function salaryInDollars(): float {
        return floatval($this->salary) / 100;
    }
}
