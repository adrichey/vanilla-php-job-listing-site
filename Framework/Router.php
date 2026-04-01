<?php

namespace Framework;

use App\Controllers\ErrorController;

class Router {
    protected $routes = [];

    private function registerRoute(string $method, string $uri, string $action): void {
        list($controller, $controllerMethod) = explode('@', $action);

        array_push($this->routes, [
            'method' => $method,
            'uri' => $uri,
            'controller' => $controller,
            'controllerMethod' => $controllerMethod,
        ]);
    }

    public function get(string $uri, string $controller): void {
        $this->registerRoute('GET', $uri, $controller);
    }

    public function post(string $uri, string $controller): void {
        $this->registerRoute('POST', $uri, $controller);
    }

    public function put(string $uri, string $controller): void {
        $this->registerRoute('PUT', $uri, $controller);
    }

    public function delete(string $uri, string $controller): void {
        $this->registerRoute('DELETE', $uri, $controller);
    }

    public function route(string $uri): void {
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        foreach ($this->routes as $route) {
            // Split the URI into segments
            $uriSegments = explode('/', trim($uri, '/'));

            // Split the current registered route into segments
            $routeSegments = explode('/', trim($route['uri'], '/'));

            // Routes have a different number of segments, not a matching route
            if (count($uriSegments) !== count($routeSegments)) {
                continue;
            }

            // Requests method don't match
            if (strtoupper($route['method']) !== strtoupper($requestMethod)) {
                continue;
            }

            // Check if we have a matching route and extract parameters
            $requestParams = [];
            $match = true;

            foreach ($routeSegments as $k => $v) {
                // Extract parameter and skip this segment if it is a variable segment
                if (str_starts_with($v, '{') && str_ends_with($v, '}')) {
                    $paramKey = trim($v, "{}");
                    $requestParams[$paramKey] = $uriSegments[$k];
                    continue;
                }

                if ($uriSegments[$k] !== $v) {
                    $match = false;
                    break;
                }
            }

            if ($match) {
                $controller = "App\\Controllers\\{$route['controller']}";
                $controllerMethod = $route['controllerMethod'];

                $controllerInstance = new $controller();
                $controllerInstance->$controllerMethod($requestParams);
                return;
            }
        }

        ErrorController::notFound();
    }
}
