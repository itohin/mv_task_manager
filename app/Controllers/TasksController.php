<?php

namespace App\Controllers;

class TasksController
{
    public function index()
    {
        $tasks = [];
        return view('tasks/index', compact('tasks'));
    }

    public function show($id)
    {
        echo $id;
    }
}