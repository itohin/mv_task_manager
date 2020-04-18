<?php

$router->get('', 'TasksController@index');
$router->get('tasks/{id}', 'TasksController@show');