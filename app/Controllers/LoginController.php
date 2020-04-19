<?php

namespace App\Controllers;

use App\Request;
use App\Validator;

class LoginController
{
    public function showLoginForm()
    {
        if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] === true){
            header("Location: /");
            exit;
        }
        return view('auth/login');
    }

    public function login()
    {
        $validator = $this->validateRequest(Request::all())->validate();
        if ($validator->hasErrors()) {
            $validator->withErrors()->redirect('login');
        }

        $login = htmlspecialchars(Request::get('login'));
        $password = htmlspecialchars(Request::get('password'));

        if ($login === 'admin' && $password === '123') {
            $_SESSION["loggedIn"] = true;
            header("Location: /");
            exit;
        }

        $validator->withErrors(['denied' => true])->redirect('login');

    }

    public function logout()
    {
        $_SESSION = [];
        session_destroy();
        header("Location: /");
    }

    public function validateRequest($inputs)
    {
        $rules = [
            'login' => ['required'],
            'password' => ['required']
        ];

        return new Validator($rules, $inputs);
    }
}