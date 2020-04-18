<?php

namespace App\Controllers;

class TasksController
{
    public function index()
    {
        echo 'Tasks list';
    }

    public function show($id)
    {
        echo $id;
    }
}