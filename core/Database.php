<?php

namespace App\Core;

require_once __DIR__ . '/../config/config.php';

use \PDO;
use \PDOException;

/**
 * Class Database
 *
 * Handles database connection and query execution using PDO.
 */
class Database
{
    private $host = DB_HOST;
    private $user = DB_USER;
    private $password = DB_PASS;
    private $dbname = DB_NAME;
    private $dbport = DB_PORT;

    private $dbh;   // Database handle
    private $stmt;  // Prepared statement
    private $error; // Connection error message

    /**
     * Database constructor.
     * Initializes PDO connection with provided configuration.
     */
    public function __construct()
    {
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname . ';port=' . $this->dbport;

        $options = [
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION // Throw exceptions on errors
        ];
        try {
            $this->dbh = new PDO($dsn, $this->user, $this->password, $options);
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            echo $this->error;
        }
    }

    /**
     * Prepares an SQL query for execution.
     *
     * @param string $sql The SQL query to prepare.
     * @return void
     */
    public function query($sql): void
    {
        $this->stmt = $this->dbh->prepare($sql);
    }

    /**
     * Executes the prepared SQL statement.
     *
     * @return bool True on success, false on failure.
     */
    public function execute()
    {
        return $this->stmt->execute();
    }

    /**
     * Executes the statement and fetches a single result as an associative array.
     *
     * @return array The fetched result.
     */
    public function result(): array
    {
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Binds a value to a parameter in the prepared statement.
     *
     * @param string|int $param The placeholder name or position.
     * @param mixed $value The value to bind.
     * @return void
     */
    public function bind($param, $value): void
    {
        $this->stmt->bindValue($param, $value);
    }
}