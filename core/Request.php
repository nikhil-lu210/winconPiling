<?php

declare(strict_types=1);

final class Request
{
    public function getMethod(): string
    {
        return strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');
    }

    public function getUri(): string
    {
        $fromQuery = $_GET['url'] ?? null;
        if (is_string($fromQuery) && $fromQuery !== '') {
            $uri = '/' . trim($fromQuery, '/');
            return $uri === '//' ? '/' : $uri;
        }

        $raw = $_SERVER['REQUEST_URI'] ?? '/';
        $path = parse_url($raw, PHP_URL_PATH);
        if (!is_string($path) || $path === '') {
            $path = '/';
        }

        $basePath = parse_url(APP_URL, PHP_URL_PATH);
        if (is_string($basePath) && $basePath !== '' && $basePath !== '/') {
            $basePath = rtrim($basePath, '/');
            if (str_starts_with($path, $basePath)) {
                $path = substr($path, strlen($basePath)) ?: '/';
            }
        }

        if (str_ends_with($path, '/index.php')) {
            $path = substr($path, 0, -strlen('index.php'));
            $path = rtrim($path, '/') ?: '/';
        }

        $path = '/' . trim($path, '/');
        return $path === '//' ? '/' : $path;
    }

    public function get(string $key, mixed $default = null): mixed
    {
        if (!isset($_GET[$key])) {
            return $default;
        }
        return $this->sanitize($_GET[$key]);
    }

    public function post(string $key, mixed $default = null): mixed
    {
        if (!isset($_POST[$key])) {
            return $default;
        }
        return $this->sanitize($_POST[$key]);
    }

    public function files(string $key): mixed
    {
        return $_FILES[$key] ?? null;
    }

    public function ip(): string
    {
        $candidates = [
            $_SERVER['HTTP_CF_CONNECTING_IP'] ?? null,
            $_SERVER['HTTP_X_FORWARDED_FOR'] ?? null,
            $_SERVER['REMOTE_ADDR'] ?? null,
        ];
        foreach ($candidates as $c) {
            if (!is_string($c) || $c === '') {
                continue;
            }
            if (str_contains($c, ',')) {
                $c = trim(explode(',', $c)[0]);
            }
            if (filter_var($c, FILTER_VALIDATE_IP)) {
                return $c;
            }
        }
        return '0.0.0.0';
    }

    public function isPost(): bool
    {
        return $this->getMethod() === 'POST';
    }

    public function all(): array
    {
        return array_merge($_GET, $_POST);
    }

    public function sanitize(mixed $value): mixed
    {
        if (is_array($value)) {
            foreach ($value as $k => $v) {
                $value[$k] = $this->sanitize($v);
            }
            return $value;
        }
        if (is_string($value)) {
            return strip_tags(trim($value));
        }
        return $value;
    }
}
