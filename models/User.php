<?php

namespace App\models;

use App\Core\Database;

/**
 * Class User
 *
 * Handles operations related to the `users` table in the database.
 */
class User
{
    private $db;

    /**
     * User constructor.
     * Initializes the database connection.
     */
    public function __construct()
    {
        $this->db = new Database();
    }

    /**
     * Creates a new user in the database.
     * Password is automatically hashed using PHP's `password_hash`.
     *
     * @param array $data Associative array containing user fields:
     *                    'first_name', 'last_name', 'email', 'phone', 'password'
     * @return void
     */
    public function create(array $data): void
    {
        $stmt = $this->db->prepare("
            INSERT INTO users (first_name, last_name, email, phone, password) 
            VALUES (:first_name, :last_name, :email, :phone, :password)");
        $stmt->bindValue(':first_name', $data['first_name']);
        $stmt->bindValue(':last_name', $data['last_name']);
        $stmt->bindValue(':email', $data['email']);
        $stmt->bindValue(':phone', $data['phone']);
        $stmt->bindValue(':password', password_hash($data['password'], PASSWORD_DEFAULT));
        $stmt->execute();
    }

    /**
     * Finds a user by their email address.
     *
     * @param string $email The email to search for.
     * @return array The user data as an associative array, or empty array if not found.
     */
    public function findByEmail(string $email): ?array
    {
        $this->db->query("SELECT * FROM users WHERE email = :email");
        $this->db->bind(':email', $email);
        return $this->db->result();
    }
}