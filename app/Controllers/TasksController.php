<?php

namespace App\Controllers;

use App\App;
use App\Request;
use App\Validator;

class TasksController
{
    public function index()
    {
        $field = Request::get('field');
        $sort = Request::get('sort');

        $field = $field ? $field : 'name';
        $sort = $sort ? $sort : 'asc';

        $limit = 3;
        $count = App::get('db')->count('tasks');
        $total = ceil($count / $limit);
        $page = $this->currentPage($total);
        $startingLimit = ($page - 1) * $limit;


        $tasks = App::get('db')->select('tasks')->order($field, $sort)->paginate($startingLimit, $limit)->get();
        return view('tasks/index', compact('tasks', 'total', 'page', 'field', 'sort'));
    }

    public function create()
    {
        return view('tasks/create');
    }

    public function edit($id)
    {
        $task = App::get('db')->find('tasks', $id);

        return view('tasks/edit', compact('task'));
    }

    public function store()
    {
        $validator = $this->validateRequest(Request::all())->validate();
        if ($validator->hasErrors()) {
            $validator->withErrors()->redirect('tasks/create');
        }

        $date = date('Y-m-d H:i:s');

        $fields = [
            'name' => htmlspecialchars(Request::get('name')),
            'email' => Request::get('email'),
            'content' => htmlspecialchars(Request::get('content')),
            'created_at' => $date,
            'updated_at' => $date
        ];

        App::get('db')->insert('tasks', $fields);
        $_SESSION['flash'] = 'Task was successfully created';

        header("Location: /");
        exit;

    }

    public function update($id)
    {
        $validator = $this->validateRequest(Request::all())->validate();
        if ($validator->hasErrors()) {
            $validator->withErrors()->redirect("/tasks/{$id}");
        }

        $date = date('Y-m-d H:i:s');

        $done = boolval(Request::get('done'));
        $fields = [
            'name' => htmlspecialchars(Request::get('name')),
            'email' => Request::get('email'),
            'content' => htmlspecialchars(Request::get('content')),
            'updated_at' => $date,
            'done' => intval($done),
            'id' => $id
        ];

        App::get('db')->update('tasks', $fields, $id);
        $_SESSION['flash'] = 'Task was successfully updated';

        header("Location: /");
        exit;

    }

    public function show($id)
    {
        echo $id;
    }

    public function currentPage($total)
    {
        $page = Request::get('page');

        if (!$page || intval($page) < 0) {
            header("Location: /?page=1");
            exit;
        }
        if ($page > $total) {
            header("Location: /?page=" . $total);
            exit;
        }

        return $page;
    }

    public function validateRequest($inputs)
    {
        $rules = [
            'name' => ['required'],
            'email' => ['required', 'email'],
            'content' => ['required'],
        ];

        return new Validator($rules, $inputs);
    }
}