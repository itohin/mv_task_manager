<?php

namespace App\Controllers;

class Controller
{
    public function flushErrors()
    {
        if (isset($_SESSION['errors'])) {
            unset($_SESSION['errors']);
        }
        if (isset($_SESSION['old'])) {
            unset($_SESSION['old']);
        }
    }
}