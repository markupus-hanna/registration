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
    public function create($data): void
    {
        $this->db->query("
            INSERT INTO users (first_name, last_name, email, phone, password) 
            VALUES (:first_name, :last_name, :email, :phone, :password)");
        $this->db->bind(':first_name', $data['first_name']);
        $this->db->bind(':last_name', $data['last_name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':phone', $data['phone']);
        $this->db->bind(':password', password_hash($data['password'], PASSWORD_DEFAULT));
        $this->db->execute();
    }

    /**
     * Finds a user by their email address.
     *
     * @param string $email The email to search for.
     * @return array The user data as an associative array, or empty array if not found.
     */
    public function findByEmail($email): array
    {
        $this->db->query("SELECT * FROM users WHERE email = :email");
        $this->db->bind(':email', $email);
        $this->db->execute();
        return $this->db->result();
    }
}