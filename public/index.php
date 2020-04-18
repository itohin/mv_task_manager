<?php

require '../vendor/autoload.php';

require __DIR__ . '/../bootstrap/core.php';

session_start();

use App\{Router, Request};

Router::load('routes.php')
    ->direct(Request::uri(), Request::method());