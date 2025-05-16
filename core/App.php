<?php

namespace App\Core;

/**
 * Class App
 *
 * The main application class responsible for routing and controller execution.
 */
class App
{
    protected $controller = 'IndexController';
    protected $method = 'dashboard';
    protected $params = [];

    /**
     * App constructor.
     *
     * Parses the URL, checks route access based on session,
     * loads the corresponding controller and method, and invokes the action.
     */
    public function __construct()
    {
        session_start();
        $urlParts = $this->parseUrl();
        require_once __DIR__ . '/../routes.php';

        $route = $urlParts[0] ?? 'dashboard';
        if (isset($urlParts[1])) {
            $route .= '/' . $urlParts[1];
        }

        $publicRoutes = ['login', 'register'];

        if (!in_array($route, $publicRoutes) && !isset($_SESSION['user'])) {
            header('Location: /?url=login');
            exit;
        }

        if (!isset($routes[$route])) {
            http_response_code(404);
            echo "404 - Route Not Found!";
            return;
        }

        $this->controller = $routes[$route]['controller'];
        $this->method = $routes[$route]['method'];
        $this->params = array_slice($urlParts, 2);

        $controllerClass = 'App\\Controllers\\' . $this->controller;

        if (!class_exists($controllerClass)) {
            http_response_code(500);
            echo "Controller class '$controllerClass' not found.";
            exit;
        }

        $this->controller = new $controllerClass;
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    /**
     * Parses the URL from the query parameter and returns the route parts as an array.
     *
     * @return array The URL segments split by "/"
     */
    private function parseUrl(): array
    {
        if (isset($_GET['url'])) {
            return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
        return [''];
    }
}
