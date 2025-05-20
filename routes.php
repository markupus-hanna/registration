<?php

return [
    'register.get' => [
        'controller' => 'RegisterController',
        'method' => 'showForm',
    ],
    'register.post' => [
        'controller' => 'RegisterController',
        'method' => 'submitForm',
    ],
    'login.get' => [
        'controller' => 'AuthController',
        'method' => 'showForm',
    ],
    'login.post' => [
        'controller' => 'AuthController',
        'method' => 'submitForm',
    ],
    'logout.get' => [
        'controller' => 'AuthController',
        'method' => 'logout',
    ],
    'dashboard.get' => [
        'controller' => 'IndexController',
        'method' => 'dashboard',
    ],
];