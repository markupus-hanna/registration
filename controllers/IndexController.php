<?php

namespace App\controllers;

use App\Core\Controller;

/**
 * Class IndexController
 *
 * Handles the main dashboard view for authenticated users.
 */
class IndexController extends Controller
{
    /**
     * Displays the dashboard page.
     *
     * Renders the dashboard view and passes the current user data from session.
     *
     * @return void
     */
    public function dashboard() {
        $this->renderView("dashboard", ["user" => $_SESSION['user']]);
    }
}