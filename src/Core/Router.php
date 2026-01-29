<?php

namespace App\Core;

class Router
{
    private array $routes = [];

    public function get(string $path, array $handler): self
    {
        $this->routes['GET'][$path] = $handler;
        return $this;
    }

    public function dispatch(): void
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri = rtrim($uri, '/') ?: '/';

        foreach ($this->routes[$method] ?? [] as $route => $handler) {
            $pattern = $this->convertToRegex($route);

            if (preg_match($pattern, $uri, $matches)) {
                array_shift($matches);
                [$controller, $action] = $handler;

                $controllerInstance = new $controller();
                call_user_func_array([$controllerInstance, $action], $matches);
                return;
            }
        }

        http_response_code(404);
        View::render('pages/404.tpl');
    }

    private function convertToRegex(string $route): string
    {
        $route = preg_replace('/\{([a-zA-Z]+)\}/', '([^/]+)', $route);
        return '#^' . $route . '$#';
    }
}

