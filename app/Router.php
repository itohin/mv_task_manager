<?php

namespace App;

class Router
{
    public $routes = [
        'GET' => [],
        'POST' => []
    ];

    public static function load($file)
    {
        $router = new static;

        require $file;

        return $router;
    }

    public function get($uri, $controller)
    {
        $this->routes['GET'][$uri] = $controller;
    }

    public function post($uri, $controller)
    {
        $this->routes['POST'][$uri] = $controller;
    }

    public function direct($uri, $requestType)
    {
        //Simple routes
        if (array_key_exists($uri, $this->routes[$requestType])) {

            return $this->callAction(
                ...explode('@', $this->routes[$requestType][$uri])
            );
        }

        //Wildcard routes
        $routes = array_filter($this->routes[$requestType], function ($route) use ($uri) {
            $needle = explode('/', $uri)[0];
            return strpos($route, $needle) !== false;
        }, ARRAY_FILTER_USE_KEY);

        foreach ($routes as $route => $handler) {
            $pattern = str_replace('{id}', '([\d]+)', $route);
            preg_match('~'.$pattern.'~', $uri, $matches);
            if (isset($matches[1])) {
                [$controller, $action] = explode('@', $this->routes[$requestType][$route]);
                return $this->callAction($controller, $action, $matches[1]);
            }
        }

        throw new \Exception('No route defined for this URI.');

    }

    protected function callAction($controller, $action, $id = null)
    {
        $controller = "App\\Controllers\\{$controller}";
        $controller = new $controller;

        if (!method_exists($controller, $action)) {
            throw new \Exception("{$controller} does not respond to the {$action} method.");
        }

        return $controller->$action($id);
    }
}