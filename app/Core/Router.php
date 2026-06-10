<?php

declare(strict_types=1);

namespace App\Core;

final class Router
{
    /** @var array<int, array{method:string, pattern:string, action:mixed}> */
    private array $routes = [];

    public function get(string $pattern, mixed $action): void
    {
        $this->add('GET', $pattern, $action);
    }

    public function post(string $pattern, mixed $action): void
    {
        $this->add('POST', $pattern, $action);
    }

    private function add(string $method, string $pattern, mixed $action): void
    {
        $this->routes[] = compact('method', 'pattern', 'action');
    }

    public function dispatch(string $method, string $uri): void
    {
        $path = parse_url($uri, PHP_URL_PATH) ?: '/';
        $path = '/' . trim($path, '/');
        $path = $path === '/' ? '/' : rtrim($path, '/');

        foreach ($this->routes as $route) {
            if ($route['method'] !== strtoupper($method)) {
                continue;
            }

            $regex = preg_replace_callback('#\{([a-zA-Z_][a-zA-Z0-9_]*)(?::([^}]+))?\}#', static function (array $matches): string {
                $name = $matches[1];
                $pattern = $matches[2] ?? '[^/]+';
                return '(?P<' . $name . '>' . $pattern . ')';
            }, $route['pattern']);
            $regex = '#^' . rtrim($regex ?: '/', '/') . '$#';
            $regex = $regex === '#^$#' ? '#^/$#' : $regex;

            if (!preg_match($regex, $path, $matches)) {
                continue;
            }

            $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
            $this->call($route['action'], $params);
            return;
        }

        http_response_code(404);
        (new Controller())->render('pages/404', [], 'site');
    }

    /**
     * @param array<string, string> $params
     */
    private function call(mixed $action, array $params): void
    {
        if (is_array($action)) {
            [$class, $method] = $action;
            $controller = new $class();
            $controller->{$method}(...array_values($params));
            return;
        }

        $action(...array_values($params));
    }
}
