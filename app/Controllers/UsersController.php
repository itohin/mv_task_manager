<?php

namespace App\Controllers;

use App\App;
use App\Request;

class UsersController
{
    public function index()
    {
        $users = App::get('db')->selectAll('users');
        return view('users', compact('users'));
    }
}