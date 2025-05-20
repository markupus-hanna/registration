<?php

namespace App\Core;

/**
 * Class App
 *
 * The main application class responsible for routing and controller execution.
 */
class App
{
    protected object $controller;
    protected string $method;
    protected array $params = [];
    protected array $routes = [];

    /**
     * App constructor.
     *
     * Parses the URL, determines controller & method based on the route,
     * and invokes the action.
     */
    public function __construct(array $routes)
    {
        $this->routes = $routes;
        session_start();

        $urlParts = $this->parseUrl();

        $routeBase = $urlParts[0] ?? 'dashboard';
        if (isset($urlParts[1])) {
            $routeBase .= '/' . $urlParts[1];
        }

        $requestMethod = strtolower($_SERVER['REQUEST_METHOD']);
        $routeKey = strtolower($routeBase . '.' . $requestMethod);

        $publicRoutes = ['login.get', 'login.post', 'register.get', 'register.post'];

        if (!in_array($routeKey, $publicRoutes) && !isset($_SESSION['user'])) {
            header('Location: /login');
            exit;
        }

        if (!isset($this->routes[$routeKey])) {
            http_response_code(404);
            echo "404 - Route Not Found!";
            return;
        }

        $controllerName = $this->routes[$routeKey]['controller'];
        $method = $this->routes[$routeKey]['method'];
        $this->params = array_slice($urlParts, 2);

        $controllerClass = 'App\\Controllers\\' . $controllerName;

        if (!class_exists($controllerClass)) {
            http_response_code(500);
            echo "Controller class '$controllerClass' not found.";
            exit;
        }

        $this->controller = new $controllerClass;
        $this->method = $method;
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    /**
     * Parses the URL from the request and returns parts as an array.
     *
     * @return array
     */
    private function parseUrl(): array
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri = trim($uri, '/');
        return explode('/', $uri);
    }
}
