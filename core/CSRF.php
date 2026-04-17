<?php

declare(strict_types=1);

final class CSRF
{
    private const SESSION_KEY = '_csrf_token';

    public static function getToken(): string
    {
        $existing = Session::get(self::SESSION_KEY);
        if (is_string($existing) && $existing !== '') {
            return $existing;
        }
        $token = bin2hex(random_bytes(32));
        Session::set(self::SESSION_KEY, $token);
        return $token;
    }

    public static function validate(string $token): bool
    {
        $stored = Session::get(self::SESSION_KEY);
        if (!is_string($stored) || $stored === '') {
            return false;
        }
        return hash_equals($stored, $token);
    }

    public static function verifyRequest(): void
    {
        $method = strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');
        if (in_array($method, ['GET', 'HEAD', 'OPTIONS'], true)) {
            return;
        }

        $token = $_POST['_csrf_token'] ?? '';
        if (!is_string($token) || !self::validate($token)) {
            $response = new Response();
            $response->abort(403, 'Invalid CSRF token.');
        }
    }
}
