<?php

namespace App;

use Exception;

class Route
{
    public static $routes;



    public static function dispatch($request)
    {

        // var_dump(self::$routes);

        $uri = $request->server['REQUEST_URI'];

        $uriParts = self::parseUri($uri);

        $method = $request->getMethod();

        // var_dump($uriParts); exit;

        foreach (self::$routes as $route) {

            // var_dump('Checking route '. $route['controller']);

            if ($route['controller'] === $uriParts['controller']) {

                // var_dump('Controller match.');

                // var_dump($uriParts); exit;

                if ($route['method'] === $method) {

                    if ($route['callback'] instanceof \Closure) {
                        return call_user_func($route['callback'], $route['params']);
                    }

                    if (count($uriParts['params']) !== count($route['params'])) {
                        // if the number of parameters match continue
                        continue;
                    }

                    // var_dump($route);

                    // here we have a match for the controller and the method
                    $controllerClass = '\App\\'.$route['controller'];

                    if (class_exists($controllerClass)) {
                        $controller = new $controllerClass;
                        // determine action here and map params

                        $params = [];

                        for ($i = 0; $i < count($uriParts['params']); $i++) {
                            $index = str_replace('{', '', str_replace('}', '', $route['params'][$i]));
                            $params[$index] = $uriParts['params'][$i];
                        }

                        if ($method === 'get') {
                            if (count($uriParts['params']) > 1) {
                                $action = 'get';
                            } else {
                                $action = 'index';
                            }
                        } else {
                            if ($method === 'post') {
                                $action = 'create';
                            }
                            if ($method === 'patch') {
                                $action = 'update';
                            }
                            if ($method === 'delete') {
                                $action = 'delete';
                            }
                        }

                        call_user_func_array([$controller, $action], $params);
                        break;
                    } else {
                        throw new Exception("Controller {$uriParts['controller']} class does not exist!");
                    }
                } else {
                    throw new Exception('Method not allowed');
                }
            }
        }

        return;
    }

    public static function parseUri($uri)
    {

        // $uri = 'loans/3';
        // $uri = 'loans/asdfd';
        // $uri = 'loans/5/borrower';

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

    public static function add($method, $route, $callback = null)
    {
        $route = ltrim($route, '/');

        if ($route !== '') {
            $parts = self::parseRoute($route);
            $controller = $parts['controller'];
            $params = $parts['params'];
        } else {
            $controller = '';
            $params = [];
        }

        self::$routes[] = [
            'method' => $method,
            'controller' => $controller,
            'params' => $params,
            'callback' => $callback
        ];
    }

    public static function parseRoute($route)
    {
        $controller = '';
        $params = [];

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

            $index = $parts[0].'/{'.$param1.'}/'.$parts[1];
            $get = $parts[0].'/{'.$param1.'}/'.$parts[1].'/{'.$param2.'}';
            $create = $index;
            $update = $get;
            $delete = $get;
        } else {
            $index = $name;
            $param1 = rtrim($name, 's');
            $param1 .= 'Id';

            $get = $name.'/{'.$param1.'}';
            $create = $index;
            $update = $get;
            $delete = $get;
        }

        self::add('get', $index);
        self::add('get', $get);
        self::add('post', $create);
        self::add('patch', $update);
        self::add('delete', $delete);
    }
}
