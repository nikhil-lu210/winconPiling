<?php

declare(strict_types=1);

/**
 * Load key=value pairs from a .env file into $_ENV and putenv().
 */
function loadEnv(string $path): void
{
    if (!is_readable($path)) {
        return;
    }

    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    if ($lines === false) {
        return;
    }

    foreach ($lines as $line) {
        $line = trim($line);
        if ($line === '' || str_starts_with($line, '#')) {
            continue;
        }
        if (!str_contains($line, '=')) {
            continue;
        }
        [$name, $value] = explode('=', $line, 2);
        $name = trim($name);
        $value = trim($value);
        if (preg_match('/^"(.*)"$/s', $value, $m) || preg_match("/^'(.*)'$/s", $value, $m)) {
            $value = $m[1];
        }
        $_ENV[$name] = $value;
        putenv($name . '=' . $value);
    }
}

function env(string $key, mixed $default = null): mixed
{
    if (array_key_exists($key, $_ENV)) {
        return $_ENV[$key];
    }
    $v = getenv($key);
    if ($v !== false) {
        return $v;
    }
    return $default;
}

function base_url(string $path = ''): string
{
    $base = rtrim((string) APP_URL, '/');
    $path = ltrim($path, '/');
    return $path === '' ? $base : $base . '/' . $path;
}

function asset(string $path): string
{
    return base_url('assets/' . ltrim($path, '/'));
}

function upload_url(string $path): string
{
    return base_url('assets/uploads/' . ltrim($path, '/'));
}

function old(string $key, mixed $default = ''): mixed
{
    return $_SESSION['_old_input'][$key] ?? $default;
}

/**
 * Flash message helper: set with two args, get with one arg.
 */
function flash(string $key, mixed $value = null): mixed
{
    if (func_num_args() === 2) {
        Session::flash($key, $value);
        return null;
    }
    return Session::getFlash($key);
}

function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function redirect(string $url): never
{
    header('Location: ' . $url);
    exit;
}

function csrf_token(): string
{
    return CSRF::getToken();
}

function csrf_field(): string
{
    return '<input type="hidden" name="_csrf_token" value="' . e(csrf_token()) . '">';
}

function is_admin_logged_in(): bool
{
    return Auth::check();
}

function log_error(string $message, array $context = []): void
{
    $line = date('c') . ' ' . $message;
    if ($context !== []) {
        $line .= ' ' . json_encode($context, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }
    $line .= PHP_EOL;
    $logFile = STORAGE_PATH . '/logs/app.log';
    @file_put_contents($logFile, $line, FILE_APPEND | LOCK_EX);
}
