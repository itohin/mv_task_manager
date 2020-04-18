<?php

require '../vendor/autoload.php';

require __DIR__ . '/../bootstrap/core.php';

use App\{Router, Request};

Router::load('routes.php')
    ->direct(Request::uri(), Request::method());