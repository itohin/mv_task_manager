<?php

namespace App;

use App\Auth\Auth;

class Router
{
    public $routes = [
        'GET' => [],
        'POST' => []
    ];

    public $auth = [];

    public static function load($file)
    {
        $router = new static;

        require $file;

        return $router;
    }

    public function get($uri, $controller, $auth = false)
    {
        if ($auth) {
            $this->auth['GET'][] = $uri;
        }
        $this->routes['GET'][$uri] = $controller;
    }

    public function post($uri, $controller, $auth = false)
    {
        if ($auth) {
            $this->auth['POST'][] = $uri;
        }
        $this->routes['POST'][$uri] = $controller;
    }

    public function direct($uri, $requestType)
    {

        //Simple routes
        if (array_key_exists($uri, $this->routes[$requestType])) {
            return $this->route($uri, $requestType);
        }

        //Wildcard routes
        $routes = array_filter($this->routes[$requestType], function ($route) use ($uri) {
            $needle = explode('/', $uri)[0];
            return strpos($route, $needle) !== false;
        }, ARRAY_FILTER_USE_KEY);

        foreach ($routes as $route => $handler) {
            $pattern = str_replace('{id}', '([\d]+)', $route);
            preg_match('~'.$pattern.'~', $uri, $matches);
            if (isset($matches[1]) && $matches[0] === $uri) {
                return $this->route($route, $requestType, $matches[1]);
            }
        }

        throw new \Exception('No route defined for this URI.');

    }

    protected function route($uri, $requestType, $param = null)
    {
        [$controller, $action] = explode('@', $this->routes[$requestType][$uri]);
        $next = $this->callAction($controller, $action, $param);

        if (in_array($uri, $this->auth[$requestType])) {
            return Auth::next($next);
        }
        return $next;
    }

    protected function callAction($controller, $action, $id = null)
    {
        $controllerName = "App\\Controllers\\{$controller}";
        $controller = new $controllerName;

        if (!method_exists($controller, $action)) {
            throw new \Exception("{$controllerName} does not respond to the {$action} method.");
        }

        return $controller->$action($id);
    }
}