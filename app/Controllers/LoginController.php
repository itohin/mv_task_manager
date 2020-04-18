<?php

namespace App\Controllers;

use App\Request;

class LoginController
{
    public function showLoginForm()
    {
        return view('auth/login');
    }

    public function login()
    {
        dd(Request::all());
    }
}