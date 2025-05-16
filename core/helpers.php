<?php

namespace App\Core;

/**
 * Checks if the current user is authenticated (logged in).
 *
 * @return bool True if the user is logged in; false otherwise.
 */
function isAuthenticated(): bool
{
    return isset($_SESSION['user']);
}

/**
 * Generates a CSRF token and stores it in the session.
 * If the token already exists, returns the existing one.
 *
 * @return string The generated or existing CSRF token.
 */
function generateCsrfToken(): string {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Validates the given CSRF token against the one stored in the session.
 *
 * @param string $token The CSRF token to validate.
 * @return bool True if the token is valid, false otherwise.
 */
function validateCsrfToken(string $token): bool {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

