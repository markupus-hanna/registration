<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../bootstrap.php';

$routes = require_once __DIR__ . '/../routes.php';

use App\Core\App;

$app = new App($routes);