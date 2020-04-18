<?php

$router->get('login', 'LoginController@showLoginForm');
$router->post('login', 'LoginController@login');
$router->get('logout', 'LoginController@logout', true);

$router->get('', 'TasksController@index');
$router->get('tasks/{id}', 'TasksController@show');
