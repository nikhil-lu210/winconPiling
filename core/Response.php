<?php

declare(strict_types=1);

final class Response
{
    public function json(mixed $data, int $status = 200): never
    {
        http_response_code($status);
        header('Content-Type: application/json; charset=UTF-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        exit;
    }

    public function redirect(string $url, int $status = 302): never
    {
        http_response_code($status);
        header('Location: ' . $url);
        exit;
    }

    public function html(string $html, int $status = 200): never
    {
        http_response_code($status);
        header('Content-Type: text/html; charset=UTF-8');
        echo $html;
        exit;
    }

    public function abort(int $code, string $message = ''): never
    {
        header('Content-Type: text/html; charset=UTF-8');
        $errorMessage = $message;
        $map = [403 => '403.php', 404 => '404.php', 500 => '500.php'];
        $file = $map[$code] ?? null;
        if ($file === null) {
            $code = 404;
            $file = '404.php';
        }
        $path = APP_PATH . '/Views/errors/' . $file;
        if (!is_file($path)) {
            http_response_code($code);
            echo '<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><title>Error</title></head><body><p>'
                . e($message !== '' ? $message : 'Error ' . $code) . '</p></body></html>';
            exit;
        }
        http_response_code($code);
        include $path;
        exit;
    }
}
