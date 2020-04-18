<?php

$router->get('login', 'LoginController@showLoginForm');
$router->post('login', 'LoginController@login');

$router->get('', 'TasksController@index');
$router->get('tasks/{id}', 'TasksController@show');

$router->get('users', 'UsersController@index', true);
$router->get('users/{id}', 'UsersController@index', true);