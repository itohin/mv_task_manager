<?php

namespace App\Auth;

use App\Request;

class Auth
{
    private $users;

    public static function check()
    {
        return isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] === true;
    }

    public static function next($next)
    {
        if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] === true){
            return $next;
        }

        header("Location: login");
        exit;
    }
}