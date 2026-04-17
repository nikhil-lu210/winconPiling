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
        http_response_code($code);
        header('Content-Type: text/html; charset=UTF-8');
        $title = 'Error ' . $code;
        $safe = e($message !== '' ? $message : $title);
        echo '<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1">'
            . '<title>' . e($title) . '</title></head><body><h1>' . e($title) . '</h1><p>' . $safe . '</p></body></html>';
        exit;
    }
}
