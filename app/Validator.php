<?php

namespace App;

class Validator
{
    public $fields = [];
    public $inputs = [];
    public $errors = [];

    public function __construct($fields, $inputs)
    {
        $this->fields = $fields;
        $this->inputs = $inputs;
    }

    public function required($input)
    {
        if (empty($this->inputs[$input])) {
            return "The {$input} field is required";
        }

        return null;
    }

    public function hasErrors()
    {
        return !empty($this->errors);
    }

    public function errors()
    {
        return $this->errors;
    }

    public function withErrors($errors = null)
    {
        $_SESSION['errors'] = $errors ? $errors : $this->errors();
        $_SESSION['old'] = $this->inputs;
        return $this;
    }

    public function redirect($path)
    {
        header('Location: ' . $path);
        exit;
    }

    public function validate()
    {
        foreach ($this->fields as $name => $rules) {
            foreach ($rules as $rule) {
                if ($error = $this->$rule($name)) {
                    $this->errors[$name][] = $error;
                }
            }
        }
        return $this;
    }
}