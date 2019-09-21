<?php

namespace App;

use Exception;

class Route
{
    /**
     * Array to hold the routes
     */
    public static $routes;

    /**
     * Dispatch request
     */
    public static function dispatch($request)
    {

        $uri = $request->server['REQUEST_URI']; // /patients

        $uriParts = self::parseUri($uri);

        $method = $request->getMethod();

        foreach (self::$routes as $route) {

            if ($route['method'] === $method) {
                
                $expression = self::parseRoute($route['expression']);

                if ($expression['controller'] === $uriParts['controller']) {

                    if (self::getRouteNumberOfParams($route['route']) !== count($uriParts['params'])) {
                        continue;
                    }

                    if ($route['expression'] instanceof \Closure) {                        
                        return call_user_func($route['expression'], $uriParts['params']);
                    }

                    $params = [];

                    for ($i = 0; $i < count($uriParts['params']); $i++) {
                        $index = str_replace('{', '', str_replace('}', '', $route['route'][$i]));
                        $params[$index] = $uriParts['params'][$i];
                    }

                    $controllerClass = '\App\\' . $expression['controller'];

                    if (class_exists($controllerClass)) {
                        $controller = new $controllerClass;            
                        return call_user_func_array([$controller, $expression['action']], $params);                      
                    } else {
                        throw new Exception("Controller {$controllerClass} class does not exist!");
                    }
                }
            }
        }

        throw new Exception('Not found');
    }

    public static function getRouteNumberOfParams($route)
    {
        preg_match_all('/\{[^\}]*\}/', $route, $matches);
        return count($matches[0]);
    }

    public static function parseUri($uri)
    {

        $uri = ltrim($uri, '/');

        $controller = '';
        $params = [];

        if (strpos($uri, '/') !== false) {
            $parts = explode('/', $uri);

            if (count($parts) == 2) {
                $controller = self::getControllerClassName([$parts[0]]);
                $params[] = $parts[1];
            }

            if (count($parts) >= 3) {

                $controller = self::getControllerClassName([$parts[0], $parts[2]]);

                $params[] = $parts[1];

                if (isset($parts[3])) {
                    $params[] = $parts[3];
                }
            }
        } else {
            $controller = self::getControllerClassName([$uri]);
            $params = [];
        }

        return [
            'controller' => $controller,
            'params' => $params
        ];
    }

    private static function getControllerClassName(array $parts)
    {
        $controller = '';

        foreach ($parts as $part) {
            $controller .= ucfirst(strtolower($part));
        }
        return $controller .= 'Controller';
    }

    public static function __callStatic($method, $params)
    {
        $route = $params[0];
        $callback = $params[1] ?? null;
        self::add($method, $route, $callback);
    }

    public static function add($method, $route, $expression)
    {

        if ($route instanceof \Closure) {
            self::$routes[] = [
                'method' => $method,
                'callback' => $route
            ];
        } else {

            self::$routes[] = [
                'method' => $method,
                'route' => $route,
                'expression' => $expression
            ];
        }
    }

    public static function parseRoute($expression)
    {
        $controller = '';
        $params = [];

        if ($expression instanceof \Closure) {                        
            return [
                'controller' => 'Controller'
            ];
        }

        if (is_string($expression) && strpos($expression, '@') !== false) {
            $expressionParts = explode('@', $expression);
            $controller = $expressionParts[0];
            $action = $expressionParts[1];
            return [
                'controller' => $controller,
                'action' => $action,
                'params' => $params
            ];
        }

        $route = $expression;

        if (strpos($route, '/')) {
            $parts = explode('/', $route);
        } else {
            $parts = [$route];
            $controller = self::getControllerClassName([$route]);
        }

        if (count($parts) == 2) {
            $controller = self::getControllerClassName([$parts[0]]);
            $params[] = $parts[1]; // {patientId}
        }

        if (count($parts) >= 3) {
            $controller = self::getControllerClassName([$parts[0], $parts[2]]);
            $params = [
                $parts[1] // {patientId}
            ];
            if (isset($parts[3])) {
                $params[] = $parts[3];  // {metricId}
            }
        }

        return [
            'controller' => $controller,
            'params' => $params
        ];
    }

    public static function resource($name)
    {
        $index = '';
        $get = '';
        $create = '';

        if (strpos($name, '.')) {
            $parts = explode('.', $name);

            $param1 = rtrim($parts[0], 's');
            $param1 .= 'Id';

            $param2 = rtrim($parts[1], 's');
            $param2 .= 'Id';

            $index = $parts[0] . '/{' . $param1 . '}/' . $parts[1];
            $get = $parts[0] . '/{' . $param1 . '}/' . $parts[1] . '/{' . $param2 . '}';
            $create = $index;
            $update = $get;
            $delete = $get;
            $controller = self::getControllerClassName([$parts[0], $parts[1]]);
        } else {
            $index = $name;
            $param1 = rtrim($name, 's');
            $param1 .= 'Id';

            $get = $name . '/{' . $param1 . '}';
            $create = $index;
            $update = $get;
            $delete = $get;
            $controller = self::getControllerClassName([$name]);
        }

        self::add('get', $index, $controller . '@index');
        self::add('get', $get, $controller . '@get');
        self::add('post', $create, $controller . '@create');
        self::add('patch', $update, $controller . '@update');
        self::add('delete', $delete, $controller . '@delete');
    }
}
