<?php

declare(strict_types=1);

final class Router
{
    /** @var list<array{0: string, 1: string, 2: string, 3: string}> */
    private array $routes = [];

    public function addRoute(string $method, string $uri, string $controller, string $action): void
    {
        $this->routes[] = [strtoupper($method), $this->normalizeUri($uri), $controller, $action];
    }

    public function dispatch(Request $request): void
    {
        $method = $request->getMethod();
        $path = $this->normalizeUri($request->getUri());

        foreach ($this->routes as $route) {
            [$routeMethod, $pattern, $controllerName, $action] = $route;
            if ($routeMethod !== $method) {
                continue;
            }
            $match = $this->matchPath($pattern, $path);
            if ($match === null) {
                continue;
            }
            $this->invokeController($controllerName, $action, $match);
            return;
        }

        $response = new Response();
        $response->abort(404, 'Page not found.');
    }

    /**
     * @return array<int, string>|null
     */
    private function matchPath(string $pattern, string $path): ?array
    {
        if (strpos($pattern, '{') === false) {
            return $pattern === $path ? [] : null;
        }

        $paramNames = [];
        $placeholder = '__WC_PARAM__';
        $tmp = preg_replace_callback(
            '/\{([a-zA-Z_][a-zA-Z0-9_]*)\}/',
            static function (array $m) use (&$paramNames, $placeholder): string {
                $paramNames[] = $m[1];
                return $placeholder;
            },
            $pattern
        );
        if (!is_string($tmp)) {
            return null;
        }
        $regex = preg_quote($tmp, '#');
        $regex = str_replace($placeholder, '([^/]+)', $regex);
        $regex = '#^' . $regex . '$#';
        if (!preg_match($regex, $path, $matches)) {
            return null;
        }
        array_shift($matches);
        return $matches;
    }

    /**
     * @param array<int, string> $params
     */
    private function invokeController(string $controllerName, string $action, array $params): void
    {
        if (!class_exists($controllerName)) {
            $response = new Response();
            $response->abort(500, 'Controller not found: ' . $controllerName);
        }
        $controller = new $controllerName();
        if (!method_exists($controller, $action)) {
            $response = new Response();
            $response->abort(500, 'Action not found: ' . $action);
        }
        $controller->{$action}(...$params);
    }

    private function normalizeUri(string $uri): string
    {
        $uri = '/' . trim($uri, '/');
        if ($uri !== '/' && str_ends_with($uri, '/')) {
            $uri = rtrim($uri, '/');
        }
        return $uri === '' ? '/' : $uri;
    }
}
