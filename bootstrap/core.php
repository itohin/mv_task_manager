<?php

use App\App;
use App\DB\{Connection, QueryBuilder};

App::bind('config', $config = require '../config/config.php');

App::bind('db', new QueryBuilder(
    Connection::make($config['DB'])
));

function view($name, $data = [])
{
    extract($data);
    return require "views/{$name}.view.php";
}

function dd($value)
{
    echo "<pre>";
    var_dump($value);
    echo "</pre>";

    die();
}

dd($config);
