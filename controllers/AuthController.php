<?php

namespace App\controllers;

use App\Core\Controller;


/**
 * Class AuthController
 *
 * Handles user authentication: login and logout.
 */
class AuthController extends Controller
{
    /**
     * Handles user login.
     *
     * If the request is POST, it verifies the provided credentials and starts a session.
     * On success — redirects to dashboard, otherwise re-renders the login view with an error.
     *
     * @return void
     */
    public function submitForm(): void
    {
        if (!validateCsrfToken($_POST['csrf_token'] ?? '')) {
            $this->renderView("login", ['error' => 'Invalid CSRF token.']);
            return;
        }

        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if (empty($email) || empty($password)) {
            $this->renderView("login", ['error' => 'Email and password are required.']);
        }

        $userModel = $this->loadModel("User");
        $user = $userModel->findByEmail($_POST['email']);
        if ($user && password_verify($_POST['password'], $user['password'])) {
            $_SESSION['user'] = $user;
            if (!empty($_POST['remember'])) {
                setcookie('remember_email', $email, time() + (86400 * 30), "/"); // 30 days
            }
            header("Location: /dashboard");
            exit;
        } else {
            $this->renderView("login", ['error' => 'Invalid credentials.']);
        }
    }

    /**
     * Displays the login form.
     *
     * This method is triggered on a GET request to the /login route.
     * It renders the login view containing the HTML form without handling any submission logic.
     *
     * @return void
     */
    public function showForm()
    {
        $this->renderView("login", [
            'rememberedEmail' => $_COOKIE['remember_email'] ?? '',
            'csrf_token' => generateCsrfToken()
        ]);
    }

    /**
     * Logs out the current user by destroying the session and redirecting to login.
     *
     * @return void
     */
    public function logout(): void
    {
        session_destroy();
        header('Location: ?route=login');
    }

    /**
     * @return mixed|string
     */
    public function extracted()
    {
        return $_COOKIE['remember_email'] ?? '';
    }
}
