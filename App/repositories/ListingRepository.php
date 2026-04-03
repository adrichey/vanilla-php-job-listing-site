<?php

namespace App\Repositories;

use PDO;
use App\Models\Listing;
use Framework\Database;
use Framework\Session;

class ListingRepository {
    private $db;

    public function __construct() {
        $dbConfig = require basePath('config/db.php');
        $this->db = new Database($dbConfig);
        $this->db->conn->setAttribute(PDO::ATTR_ORACLE_NULLS, PDO::NULL_TO_STRING);
    }

    /**
     * @return Listing[]
     */
    public function fetchAll(): array {
        return $this->db->query('SELECT * FROM listings ORDER BY created_at DESC')
            ->fetchAll(PDO::FETCH_CLASS, Listing::class);
    }

    public function fetch(int $id): Listing|false {
        $statement = $this->db->query('SELECT * FROM listings WHERE id = :id LIMIT 1', [
            'id' => $id,
        ]);

        $statement->setFetchMode(PDO::FETCH_CLASS, Listing::class);
        return $statement->fetch();
    }

    public function store(Listing $listing): int {
        $params = [
            'user_id' => Session::get('user')['id'],
            'title' => $listing->title,
            'description' => $listing->description,
            'tags' => $listing->tags,
            'salary' => $listing->salary,
            'salary_frequency' => $listing->salary_frequency,
            'requirements' => $listing->requirements,
            'benefits' => $listing->benefits,
            'company' => $listing->company,
            'address' => $listing->address,
            'city' => $listing->city,
            'state' => $listing->state,
            'zip_code' => $listing->zip_code,
            'phone' => $listing->phone,
            'email' => $listing->email,
        ];

        // Prepare query fields to persist listing to DB
        $fields = implode(',', array_keys($params));
        $values = ':' . implode(',:', array_keys($params));
        $query = "INSERT INTO listings ({$fields}) VALUES ({$values})";

        // Default empty values to null for query
        foreach ($params as $key => $value) {
            if (empty($value)) {
                $listingData[$key] = null;
            }
        }

        $this->db->query($query, $params);

        return intval($this->db->conn->lastInsertId());
    }

    public function update(Listing $listing): void {
        $params = [
            'id' => $listing->id,
            'user_id' => Session::get('user')['id'],
            'title' => $listing->title,
            'description' => $listing->description,
            'tags' => $listing->tags,
            'salary' => $listing->salary, // salary is stored in cents
            'salary_frequency' => $listing->salary_frequency,
            'requirements' => $listing->requirements,
            'benefits' => $listing->benefits,
            'company' => $listing->company,
            'address' => $listing->address,
            'city' => $listing->city,
            'state' => $listing->state,
            'zip_code' => $listing->zip_code,
            'phone' => $listing->phone,
            'email' => $listing->email,
        ];

        // Prepare query fields to persist listing to DB
        $fields = implode(',', array_map(
            fn($param) => "{$param} = :{$param}",
            array_keys($params)
        ));

        $query = "UPDATE listings SET {$fields} WHERE id = :id";

        // Default empty values to null for query
        foreach ($params as $key => $value) {
            if (empty($value)) {
                $listingData[$key] = null;
            }
        }

        $this->db->query($query, $params);
    }

    public function destroy(Listing $listing): void {
        $this->db->query('DELETE FROM listings WHERE id = :id', [
            'id' => $listing->id
        ]);
    }

    /**
     * @return Listing[]
     */
    public function search(string $keywords, string $location): array {
        // Build keywords WHERE clause
        $keywordFields = ['title', 'description', 'tags', 'company'];
        $keywordSearch = implode(' OR ', array_map(fn($keyword) => "{$keyword} LIKE :keywords", $keywordFields));

        // Build location WHERE clause
        $locationFields = ['city', 'state', 'zip_code'];
        $locationSearch = implode(' OR ', array_map(fn($keyword) => "{$keyword} LIKE :location", $locationFields));

        $query = "SELECT * FROM listings WHERE ({$keywordSearch}) AND ({$locationSearch})";

        $params = [
            'keywords' => "%{$keywords}%",
            'location' => "%{$location}%",
        ];

        return$this->db->query($query, $params)
            ->fetchAll(PDO::FETCH_CLASS, Listing::class);
    }
}
