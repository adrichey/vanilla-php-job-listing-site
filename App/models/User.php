<?php

namespace App\Models;

class User {
    public int $id = 0;
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $city = '';
    public string $state = '';
    public string $zip_code = '';
    public string $created_at = '';
    public string $updated_at = '';

    public function __construct(array $listingData = []) {
        if (!empty($listingData)) {
            $this->id = isset($listingData['id']) ? intval($listingData['id']) : 0;
            $this->name = isset($listingData['name']) ? (string) $listingData['name'] : '';
            $this->email = isset($listingData['email']) ? (string) $listingData['email'] : '';
            $this->password = isset($listingData['password']) ? (string) $listingData['password'] : '';
            $this->city = isset($listingData['city']) ? (string) $listingData['city'] : '';
            $this->state = isset($listingData['state']) ? (string) $listingData['state'] : '';
            $this->zip_code = isset($listingData['zip_code']) ? (string) $listingData['zip_code'] : '';
            $this->created_at = isset($listingData['created_at']) ? (string) $listingData['created_at'] : '';
            $this->updated_at = isset($listingData['updated_at']) ? (string) $listingData['updated_at'] : '';
            return;
        }
    }
}
