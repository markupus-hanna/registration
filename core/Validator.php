<?php

namespace App\Core;

/**
 * Class Validator
 *
 * Provides various validation methods for user input.
 */
class Validator
{
    private array $data;
    private array $errors = [];

    /**
     * Validator constructor.
     *
     * @param array $data Input data to validate.
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Validates that the given fields are not empty.
     *
     * @param array $fields Array of field names to check.
     * @return void
     */
    public function required(array $fields): void
    {
        foreach ($fields as $field) {
            if (empty(trim($this->data[$field] ?? ''))) {
                $this->errors[$field] = ucfirst($field) . ' is required';
            }
        }
    }

    /**
     * Validates that the given field is a valid email.
     *
     * @param string $field The field name to validate.
     * @return void
     */
    public function email(string $field): void
    {
        if (!empty($this->data[$field]) && !filter_var($this->data[$field], FILTER_VALIDATE_EMAIL)) {
            $this->errors[$field] = 'Invalid email format';
        }
    }

    /**
     * Validates that the given field contains a valid phone number.
     * Accepts digits with optional leading + and length between 10 and 15.
     *
     * @param string $field The field name to validate.
     * @return void
     */
    public function phone(string $field): void
    {
        if (!empty($this->data[$field]) && !preg_match('/^\+?[0-9]{10,15}$/', $this->data[$field])) {
            $this->errors[$field] = 'Invalid phone number';
        }
    }

    /**
     * Normalizes a phone number by removing non-digit characters except the first "+".
     *
     * @param string $field The raw phone input.
     * @return string The normalized phone number.
     */
    public function normalizePhone(string $field): string
    {
        $phone = preg_replace('/[^\d+]/', '', $field);
        return preg_replace('/(?!^)\+/', '', $phone);
    }


    /**
     * Validates that the given field has at least a certain number of characters.
     *
     * @param string $field The field name to validate.
     * @param int $min Minimum allowed length.
     * @return void
     */
    public function minLength(string $field, int $min): void
    {
        if (!empty($this->data[$field]) && strlen($this->data[$field]) < $min) {
            $this->errors[$field] = ucfirst($field) . " must be at least $min characters";
        }
    }

    /**
     * Validates that the given field does not exceed the maximum allowed length.
     *
     * @param string $field The field name to validate.
     * @param int $max Maximum allowed length.
     * @return void
     */
    public function maxLength(string $field, int $max): void
    {
        if (!empty($this->data[$field]) && strlen($this->data[$field]) > $max) {
            $this->errors[$field] = ucfirst($field) . " must be at less $max characters";
        }
    }

    /**
     * Validates that the password is strong.
     * Requirements:
     * - 6 to 16 characters
     * - At least one lowercase letter
     * - At least one uppercase letter
     * - At least one digit
     * - At least one special character
     *
     * @param string $field The field name to validate.
     * @return void
     */
    public function strongPassword(string $field): void
    {
        $password = $this->data[$field] ?? '';

        if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{6,16}$/', $password)) {
            $this->errors[$field] = 'Password must be at least 8 characters and contain at least one lowercase letter, one uppercase letter, one number, and one special character.';
        }
    }

    /**
     * Returns an array of validation errors.
     *
     * @return array Array of error messages by field name.
     */
    public function errors(): array
    {
        return $this->errors;
    }
}
