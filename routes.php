<?php

$routes = [
    'register' => ['controller' => 'RegisterController', 'method' => 'register'],
    'login' => ['controller' => 'AuthController', 'method' => 'login'],
    'logout' => ['controller' => 'AuthController', 'method' => 'logout'],
    'dashboard' => ['controller' => 'IndexController', 'method' => 'dashboard'],
];