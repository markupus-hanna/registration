<?php

namespace App\Core;

use PDO;
use PDOException;

/**
 * Class Database
 *
 * Handles database connection and query execution using PDO.
 */
class Database
{
    private static ?PDO $instance = null;
    private PDO $dbh;   // Local reference to shared DB instance
    private \PDOStatement $stmt; // Prepared statement
    private string $error = '';

    /**
     * Database constructor.
     * Uses singleton instance for PDO and stores a local handle.
     */
    public function __construct()
    {
        $this->dbh = self::getInstance();
    }

    /**
     * Returns a singleton PDO instance.
     *
     * @return PDO
     */
    public static function getInstance(): PDO
    {
        if (!self::$instance) {
            $host = getenv("DB_HOST");
            $db   = getenv("DB_NAME");
            $user = getenv("DB_USER");
            $pass = getenv("DB_PASS");

            $dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";

            $options = [
                PDO::ATTR_PERSISTENT         => true,
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ];

            try {
                self::$instance = new PDO($dsn, $user, $pass, $options);
            } catch (PDOException $e) {
                die("Database connection error: " . $e->getMessage());
            }
        }

        return self::$instance;
    }

    /**
     * Prepares an SQL query for execution.
     *
     * @param string $sql
     * @return void
     */
    public function query(string $sql): void
    {
        $this->stmt = $this->dbh->prepare($sql);
    }

    /**
     * Executes the prepared SQL statement.
     *
     * @return bool
     */
    public function execute(): bool
    {
        return $this->stmt->execute();
    }

    /**
     * Executes the statement and fetches a single result.
     *
     * @return array|null
     */
    public function result(): ?array
    {
        $this->execute();
        return $this->stmt->fetch() ?: null;
    }

    /**
     * Binds a value to a parameter in the prepared statement.
     *
     * @param string|int $param
     * @param mixed $value
     * @return void
     */
    public function bind(string|int $param, mixed $value): void
    {
        $this->stmt->bindValue($param, $value);
    }
}
