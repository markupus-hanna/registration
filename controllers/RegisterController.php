<?php

namespace App\controllers;

use App\Core\Controller;
use App\Core\Validator;

/**
 * Class RegisterController
 *
 * Handles user registration and input validation.
 */
class RegisterController extends Controller
{
    /** @const int Minimum length for first name and last name */
    const MIN_LENGTH = 4;

    /** @const int Maximum allowed length for the first name */
    const MAX_FIRST_NAME_LENGTH = 15;

    /** @const int Maximum allowed password length */
    const MAX_PASSWORD_LENGTH = 16;

    /** @const int Minimum required password length */
    const MIN_PASSWORD_LENGTH = 6;

    /** @const int Maximum allowed length for the last name */
    const MAX_LAST_NAME_LENGTH = 25;

    /**
     * Displays the user registration form.
     *
     * This method is triggered on a GET request to the /register route.
     * It renders the registration view containing the HTML form without handling any submission logic.
     *
     * @return void
     */
    public function showForm(): void
    {
        $this->renderView('register');
    }

    /**
     * Handles user registration.
     *
     * Validates input data using the Validator class,
     * checks for existing email, and stores a new user if valid.
     * Redirects to login page upon success.
     *
     * @return void
     */
    public function submitForm(): void
    {
        $userModel = $this->loadModel("User");

        // Normalize phone format before validation
        $_POST['phone'] = (new Validator([]))->normalizePhone($_POST['phone'] ?? '');

        $validator = new Validator($_POST);
        $validator->required(['first_name', 'last_name', 'email', 'phone', 'password']);
        $validator->minLength('first_name', self::MIN_LENGTH);
        $validator->maxLength('first_name', self::MAX_FIRST_NAME_LENGTH);
        $validator->minLength('last_name', self::MIN_LENGTH);
        $validator->maxLength('last_name', self::MAX_LAST_NAME_LENGTH);
        $validator->email('email');
        $validator->phone('phone');
        $validator->minLength('password', self::MIN_PASSWORD_LENGTH);
        $validator->maxLength('password', self::MAX_PASSWORD_LENGTH);
        $validator->strongPassword('password');

        $errors = $validator->errors();

        // Check if email already exists
        if ($userModel->findByEmail($_POST['email'])) {
            $errors['email'] = 'Email is already taken';
        }
        if (empty($errors)) {
            $userModel->create($_POST);
            header("Location: /?url=login");
            exit;
        } else {
            $this->renderView('register', ['errors' => $errors]);
        }
    }
}
