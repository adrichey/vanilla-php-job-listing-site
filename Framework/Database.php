<?php

namespace Framework;

use Exception;
use PDO;
use PDOStatement;
use PDOException;

class Database {
    public $conn;

    public function __construct() {
        $env = parse_ini_file(basePath('.env'));

        $host = $env['DB_HOST'] ?? '';
        $port = $env['DB_PORT'] ?? '';
        $dbName = $env['DB_NAME'] ?? '';
        $username = $env['DB_USERNAME'] ?? '';
        $password = $env['DB_PASSWORD'] ?? '';

        $dsn = "mysql:host={$host};port={$port};dbname={$dbName}";

        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        ];

        try {
            $this->conn = new PDO($dsn, $username, $password, $options);
        } catch (PDOException $e) {
            throw new Exception("Database connection failed: {$e->getMessage()}");
        }
    }

    /**
     * Query the database
     * 
     * @param string $query
     * 
     * @return PDOStatement
     * @throws PDOException
     */
    public function query(string $query, array $parameters = []): PDOStatement {
        try {
            $statement = $this->conn->prepare($query);
            $statement->execute($parameters);
            return $statement;
        } catch (PDOException $e) {
            throw new Exception("Query failed to execute: {$e->getMessage()}");
        }
    }
}
