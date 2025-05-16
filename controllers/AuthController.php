<?php

namespace App\controllers;

use App\Core\Controller;
use function App\Core\validateCsrfToken;


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
    public function login(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
                header("Location: /?url=dashboard");
                exit;
            } else {
                $this->renderView("login", ['error' => 'Invalid credentials.']);
            }
        } else {
            $rememberedEmail = $_COOKIE['remember_email'] ?? '';
            $this->renderView("login", ['rememberedEmail' => $rememberedEmail]);
        }
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
}
