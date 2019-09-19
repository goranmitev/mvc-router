<?php

namespace App;

class Route
{
    public static $routes;

    public static function add($method, $uri, $expression, $action = null)
    {
        $uri = ltrim($uri, '/');

        self::$routes[$method][$uri] = [
            $expression,
            $action
        ];
    }

    public static function resource($name)
    {
        if (strpos($name, '.')) {
            $parts = explode('.', $name);
            $controller = ucfirst(strtolower($parts[0])).ucfirst(strtolower($parts[1])).'Controller';
        } else {
            $controller = ucfirst(strtolower($name)).'Controller';
        }

        $uri = $name;

        self::add('get', $uri, $controller, 'index');
        self::add('get', $uri.'/{id}', $controller, 'get');
        self::add('post', $uri, $controller, 'create');
        self::add('patch', $uri.'/{id}', $controller, 'update');
        self::add('delete', $uri.'/{id}', $controller, 'delete');
    }

    public static function dispatch($request)
    {
        // var_dump(self::$routes);

        $uri = basename($request->server['REQUEST_URI']);

        $method = $request->getMethod();

        if (isset(self::$routes[$method][$uri])) {
            $match = self::$routes[$method][$uri];

            if ($match[0] instanceof \Closure) {
                call_user_func($match[0], $match[1]);
            } else {
                $action = $match[1];

                // load controller
                $controllerClass = '\App\\'.$match[0];

                $controller = new $controllerClass;
                call_user_func_array([$controller, $action], []);
            }
        } else {
            http_response_code(404);
        }

        exit;
    }

    public static function __callStatic($method, $params)
    {
        self::add($method, $params[0], $params[1]);
    }
}
