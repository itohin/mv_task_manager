<?php

$router->get('login', 'LoginController@showLoginForm');
$router->post('login', 'LoginController@login');
$router->get('logout', 'LoginController@logout', true);

$router->get('', 'TasksController@index');
$router->get('tasks/create', 'TasksController@create');
$router->post('tasks', 'TasksController@store');
$router->get('tasks/{id}', 'TasksController@edit', true);
$router->post('tasks/{id}', 'TasksController@update', true);
