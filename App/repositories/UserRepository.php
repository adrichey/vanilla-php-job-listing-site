<?php

namespace App\Repositories;

use PDO;
use App\Models\User;
use Framework\Database;

class UserRepository {
    private $db;

    public function __construct() {
        $dbConfig = require basePath('config/db.php');
        $this->db = new Database($dbConfig);
        $this->db->conn->setAttribute(PDO::ATTR_ORACLE_NULLS, PDO::NULL_TO_STRING);
    }

    public function fetchByEmail(string $email): User|false {
        $statement = $this->db
            ->query('SELECT * FROM users WHERE email = :email LIMIT 1', ['email' => $email]);

        $statement->setFetchMode(PDO::FETCH_CLASS, User::class);
        return $statement->fetch();
    }

    public function store(User $user): int {
        $params = [
            'name' => $user->name, 
            'email' => $user->email, 
            'password' => $user->password, 
            'city' => $user->city, 
            'state' => $user->state, 
            'zip_code' => $user->zip_code, 
        ];

        // Prepare query fields to persist listing to DB
        $fields = implode(',', array_keys($params));
        $values = ':' . implode(',:', array_keys($params));
        $query = "INSERT INTO users ({$fields}) VALUES ({$values})";

        // Default empty values to null for query
        foreach ($params as $key => $value) {
            if (empty($value)) {
                $listingData[$key] = null;
            }
        }

        $this->db->query($query, $params);

        return intval($this->db->conn->lastInsertId());
    }
}
