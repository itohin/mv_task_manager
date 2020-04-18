<?php

use App\App;
use App\DB\{Connection, QueryBuilder};

App::bind('config', $config = require '../config/config.php');

App::bind('db', new QueryBuilder(
    Connection::make($config['DB'])
));

function view($name, $data = [])
{
    ob_start();
    extract($data);
    $extends = null;
    require "../views/{$name}.view.php";
    $content = ob_get_clean();

    return require "../views/layouts/app.view.php";
}

function dd($value)
{
    echo "<pre>";
    var_dump($value);
    echo "</pre>";

    die();
}

