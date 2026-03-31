<?php

namespace Framework;

class Router {
    protected $routes = [];

    private function registerRoute(string $method, string $uri, string $controller): void
    {
        array_push($this->routes, [
            'method' => $method,
            'uri' => $uri,
            'controller' => $controller,
        ]);
    }

    public function get(string $uri, string $controller): void
    {
        $this->registerRoute('GET', $uri, $controller);
    }

    public function post(string $uri, string $controller): void
    {
        $this->registerRoute('POST', $uri, $controller);
    }

    public function put(string $uri, string $controller): void
    {
        $this->registerRoute('PUT', $uri, $controller);
    }

    public function delete(string $uri, string $controller): void
    {
        $this->registerRoute('DELETE', $uri, $controller);
    }

    public function route(string $method, string $uri): void
    {
        foreach ($this->routes as $route) {
            if ($route['method'] == $method && $route['uri'] == $uri) {
                require(basePath('App/' . $route['controller']));
                return;
            }
        }

        $this->error();
    }

    private function error(int $httpCode = 404): void
    {
        http_response_code($httpCode);
        loadView("error/{$httpCode}");
        exit;
    }
}